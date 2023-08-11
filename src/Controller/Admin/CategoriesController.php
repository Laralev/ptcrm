<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

class CategoriesController extends AppController
{
    
    public function index($_pid=null)
    {

        if ($this->request->is('post')) {

            $this->autoRender  = false;
            
            $_method = !empty($_GET['method']) ? $_GET['method'] : '';

            $_dir = !empty($_GET['direction']) ? $_GET['direction'] : 'DESC';
            $_col = !empty($_GET['col']) ? $_GET['col'] : 'id';
            $_k = isset($_GET['k']) ? $_GET['k'] : '';
            
            $conditions=[];
            if(isset($_pid)){
                $conditions['Categories.parent_id'] = $_pid;
            }
            if(strlen($_k) > 0){
                if( $_method == 'like'){
                    $conditions[$_col.' LIKE '] = '%'.$_k.'%';
                }else{
                    $conditions[$_col] = is_numeric( $_k ) ? $_k*1 : $_k;
                }
            }
            
            $this->paginate = [ 
                'order'=>[ $_col => $_dir ],
                'conditions' => $conditions,
                'contain' => ['ParentCategories'=>['fields'=>['category_name']]]
            ];

            $categories = $this->paginate($this->Categories);
            
            echo json_encode([
                    "status"=>"SUCCESS", 
                    "data"=>$this->Do->convertJson($categories), 
                    "paging"=>$this->Paginator->getPagingParams()["Categories"]
                ], JSON_UNESCAPED_UNICODE);  die();
            
        }

    }
    
    public function view($id = null)
    {
        $rec = $this->Categories->get($id, [
            'contain' => [],
        ]);

        $this->set('rec', $rec);
    }
    
    public function add()
    {
        $category = $this->Categories->newEmptyEntity();
        if ($this->request->is('post')) {
            $cats = explode("::", $this->request->getData('category_name') );
            $data = [];
            foreach($cats as $k=>$cat){
                $data[$k] = $this->request->getData();
                $data[$k]["category_name"] = $cat;
                $data[$k]["category_configs"] = json_encode($this->request->getData('category_configs'));
                $data[$k]["slug"] = $this->Do->slugger($cat);
                $data[$k]["rec_state"] = 1;
            }
            $category = $this->Categories->patchEntities($category, $data);
            if ($this->Categories->saveMany($category)) {
                $this->Flash->success(__('save-success'));
                return $this->redirect($this->referer());
            }else{
                $this->Flash->error(__('save-fail'));
            }
        }
        $parents = $this->Categories->ParentCategories->find('list', [
            'conditions' => ['parent_id'=> empty($_GET['parent_id']) ? 0 : $_GET['parent_id'] ]
        ]);
        $languages = $this->Do->lcl( $this->Do->get('langs'));
        $this->set(compact('category', 'parents', 'languages'));
    }
    
    public function edit($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => [],
        ]);
        $category->category_configs = json_decode($category->category_configs);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            $category->category_configs = json_encode($this->request->getData('category_configs'));
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('save-success'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('save-fail'));
        }
        $conds = isset($_GET['parent_id']) ? ['parent_id'=>$_GET['parent_id']] : ['id'=>$category->parent_id];

        $parents = $this->Categories->find('list', [
            'conditions' =>  $conds
        ]);
        
        $languages = $this->Do->lcl($this->Do->get('langs'));
        $this->set(compact('category', 'parents', 'languages'));
    }
    
    public function save($id = -1) 
    {
        $this->request->allowMethod(['post', 'put', 'patch']);
        
        $this->autoRender  = false;
        $dt = json_decode( file_get_contents('php://input'), true);

        if ($this->request->is(['patch', 'put'])) {
            $rec = $this->Categories->get($dt['id']);
        }
        if ($this->request->is(['post'])) {
            $rec = $this->Categories->newEmptyEntity();
            $dt['id'] = null;
        }

        // Upload photos
        if(!empty($dt['img'])){
			$fname = time();
			$thumb_params = [
				['doThumb'=>true, 'w'=>350, 'h'=>350, 'dst'=>'thumb']
			];
			foreach( $dt['img'] as $k=>$img){
				$this->Images->uploader('img/categories_photos', $img, $fname.$k, $thumb_params);
			}
            $sep = empty($rec->pro_photos) ? '' : ',';
			$dt['pro_photos'] = $rec->pro_photos.$sep.$this->Images->getPhotosNames();
        }

        $dt['category_configs'] = json_encode( !empty($dt['category_configs']) ? $dt['category_configs'] : ['icon'=>'', 'isProtected'=>''] );
        
        $rec = $this->Categories->patchEntity($rec, $dt);
		
        if ($newRec = $this->Categories->save($rec)) {
            echo json_encode(["status"=>"SUCCESS", "data"=>$newRec]); die();
        }
        echo json_encode(["status"=>"FAIL", "data"=>$rec->getErrors()]); die();
    }
    
	
    public function delete($id = null)
    {
        if(!$id){
            echo json_encode( ["status"=>"FAIL", "msg"=>__("is-selected-empty-msg"), "data"=>[]] ); die();
        }
        $this->request->allowMethod(['post', 'delete']);
        $this->autoRender  = false;

        if(!$this->_isAuthorized(true)){
            echo json_encode( ["status"=>"FAIL", "msg"=>__("no-auth"), "data"=>[]] ); die();
        }
        $delRec = $this->Categories->deleteAll(['id IN ' => explode(",", $id)]);
        
        if ($delRec) {
            $res = ["status"=>"SUCCESS", "data"=>$delRec];
        }else{
            $res = ["status"=>"FAIL", "data"=>$delRec->getErrors()];
        }
        echo json_encode($res);die();

        return $this->redirect(['action' => 'index']);
    }
    
    public function enable($val=1, $ids=null)
    {
        if(!$ids){
            echo json_encode( ["status"=>"FAIL", "msg"=>__("is-selected-empty-msg"), "data"=>[]] ); die();
        }
        $this->request->allowMethod(['post', 'delete']);
        $this->autoRender  = false;
        if(!$this->_isAuthorized(true)){
            echo json_encode( ["status"=>"FAIL", "msg"=>__("no-auth"), "data"=>[]] ); die();
        }
        $records = json_decode( file_get_contents('php://input'), true);
        $errors = [];
        foreach($records as $rec){
            if(!is_numeric($rec)){continue;}
            $dt= $this->Categories->newEmptyEntity();;
            $dt["id"] = $rec;
            $dt["rec_state"] = $val;
            if(!$this->Categories->save($dt)){
                $errors[] = $dt->getErrors();
            }
        }
        
        if (empty($errors)) {
            $res = ["status"=>"SUCCESS", "data"=>$dt];
        }else{
            $res = ["status"=>"FAIL", "data"=>$dt->getErrors()];
        }
        echo json_encode($res);die();

    }
    

}
