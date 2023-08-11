<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

class SalesController extends AppController
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
                $conditions['Sales.source_id'] = $_pid;
            }
            if(strlen($_k) > 0){
                if( $_method == 'like'){
                    $conditions[$_col.' LIKE '] = '%'.$_k.'%';
                }else{
                    $conditions[$_col] = is_numeric( $_k ) ? $_k*1 : $_k;
                }
            }

          

            
            $sales = $this->paginate($this->Sales, ['contain'=>['Clients','Segements','Sources','Pools']]);
            

            $conditions = [ ];

            // Filters and Search
            $_from = !empty($_GET['from']) ? $_GET['from'] : '';
            $_to = !empty($_GET['to']) ? $_GET['to'] : '';

            $_method = !empty($_GET['method']) ? $_GET['method'] : '';
            $_col = !empty($_GET['col']) ? $_GET['col'] : 'id';
            $_k = (isset($_GET['k']) && strlen($_GET['k'])>0) ? $_GET['k'] : false;

            $_dir = !empty($_GET['direction']) ? $_GET['direction'] : 'DESC';

            if($_k !== false){

                $_method == 'like' ?  $conditions[$_col.' LIKE '] = '%'.$_k.'%' : $conditions['Sales.'.$_col] = $_k;  // note = $col condition is not correct 
                
            }
            
            $data=[];
            $_id = $this->request->getQuery('id');
            $_list = $this->request->getQuery('list');
            $_clientsList = $this->request->getQuery('clientsList');

            
            // ONE RECORD
            if(!empty($_id)){
                $data = $this->Sales-> get( $_id , ['contain' => ['ClientSpecs', 'Reports']] )->toArray();
                //dd( $data);
                echo json_encode(["status"=>"SUCCESS",  "data"=>$this->Do->convertJson( $data )], JSON_UNESCAPED_UNICODE); die();
                
            }
            
            // LIST
            if(!empty($_list)){ 
                $data = $this->paginate($this->Sales, [
                    "order"=>[ $_col => $_dir ],
                    "conditions"=>$conditions,
                ]);

            }
            
            // CLIENTS LIST
            if(!empty($_clientsList)){ 
                $clientListCond = [];
                if(!empty($_clientsList)){
                    $clientListCond = ["client_name LIKE"=>'%'.$_clientsList.'%'];
                }
                $clients = $this->Clients->find('list', ["order"=>[ "client_name" => "ASC" ], "conditions"=>$clientListCond]);
                echo json_encode( 
                    [ "status"=>"SUCCESS",  "data"=>$clients], JSON_UNESCAPED_UNICODE); die();
            }
             
            echo json_encode( 
                [ "status"=>"SUCCESS",  "data"=>$this->Do->convertJson( $data, $sales ), "paging"=>$this->Paginator->getPagingParams()["Sales"]], 
                JSON_UNESCAPED_UNICODE); die();
        }



            //for list clients
            $clients = $this->getTableLocator()->get('Clients')->find('list')->toArray();



            //for list segements
            $parentSegIds = [15];//when another category named segments is added, to add it here as well.
            $categoriesSegement = $this->getTableLocator()->get('Categories')->find('all')
                ->where(['parent_id IN' => $parentSegIds])
                ->toArray();
            
            $optionsSegement = [];
            foreach ($categoriesSegement as $category) {
                $optionsSegement[$category->id] = $category->category_name;
            }



            //for list sources
            $parentSourceIds = [12];
            $categoriesSource = $this->getTableLocator()->get('Categories')->find('all')
                ->where(['parent_id IN' => $parentSourceIds])
                ->toArray();
            
            $optionsSource = [];
            foreach ($categoriesSource as $category) {
                $optionsSource[$category->id] = $category->category_name;
            }



            //for list pools
            $parentPoolIds = [25];
            $categoriesPool = $this->getTableLocator()->get('Categories')->find('all')
                ->where(['parent_id IN' => $parentPoolIds])
                ->toArray();
            
            $optionsPool = [];
            foreach ($categoriesPool as $category) {
                $optionsPool[$category->id] = $category->category_name;
            }
                        

            $this->set(compact('clients','optionsSegement','optionsSource','optionsPool'));
    }
    
    public function view($id = null)
    {
        
        $rec = $this->Sales->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('rec'));
       
    }
  
    public function add()
    {
        // $sales = $this->Sales->newEmptyEntity();
        // if ($this->request->is('post')) {
        //     $cats = explode("::", $this->request->getData('sale_id') );
        //     $data = [];
        //     foreach($cats as $k=>$cat){
        //         $data[$k] = $this->request->getData();
        //         $data[$k]["sale_id"] = $cat;
        //         $data[$k]["sales_configs"] = json_encode($this->request->getData('sales_configs'));
        //         $data[$k]["slug"] = $this->Do->slugger($cat);
        //         $data[$k]["rec_state"] = 1;
        //     }
        //     $sales = $this->Sales->patchEntities($sales, $data);
        //     if ($this->Sales->saveMany($sales)) {
        //         $this->Flash->success(__('save-success'));
        //         return $this->redirect($this->referer());
        //     }else{
        //         $this->Flash->error(__('save-fail'));
        //     }
        // }
        // $parents = $this->Sales->ParentSales->find('list', [
        //     'conditions' => ['source_id'=> empty($_GET['source_id']) ? 0 : $_GET['source_id'] ]
        // ]);
        // $languages = $this->Do->lcl( $this->Do->get('langs'));
        // $this->set(compact('sales', 'parents', 'languages'));

        $dt = json_decode(file_get_contents('php://input'), true);
        
        if ($this->request->is(['patch', 'put'])) {
            $rec = $this->Sales->get($dt['id']);
        }

        // add mode
        if ($this->request->is(['post'])) {
            $dt['id'] = null;
        }

        if ($this->request->is(['post', 'patch', 'put'])) {
            $this->autoRender = false;

            $rec = $this->Sales->newEntity($dt, ['associated' => ['SaleSpecs','Clients','ClientSpecs']]);
            if ($newRec = $this->Sales->save($rec)) {
                echo json_encode(["status" => "SUCCESS", "data" => $this->Do->convertJson($newRec)]);
                die();
            }

            echo json_encode(["status" => "FAIL", "data" => $rec->getErrors()]);
            die();
        }
    }
    
    public function edit($id = null)
    {
        $sales = $this->Sales->get($id, [
            'contain' => [],
        ]);
        $sales->sales_configs = json_decode($sales->sales_configs);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sales = $this->Sales->patchEntity($sales, $this->request->getData());
            $sales->sales_configs = json_encode($this->request->getData('sales_configs'));
            if ($this->Sales->save($sales)) {
                $this->Flash->success(__('save-success'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('save-fail'));
        }
        $conds = isset($_GET['source_id']) ? ['source_id'=>$_GET['source_id']] : ['id'=>$sales->source_id];

        $parents = $this->Sales->find('list', [
            'conditions' =>  $conds
        ]);
        
        // $languages = $this->Do->lcl($this->Do->get('langs'));
        // $this->set(compact('sales', 'parents', 'languages'));
    }
    
    public function save($id = -1) 
    {
        // $this->request->allowMethod(['post', 'put', 'patch']);
        
        // $this->autoRender  = false;
        // $dt = json_decode( file_get_contents('php://input'), true);

        // if ($this->request->is(['patch', 'put'])) {
        //     $rec = $this->Sales->get($dt['id']);
        // }
        // if ($this->request->is(['post'])) {
        //     $rec = $this->Sales->newEmptyEntity();
        //     $dt['id'] = null;
        // }

        // // Upload photos
        // if(!empty($dt['img'])){
		// 	$fname = time();
		// 	$thumb_params = [
		// 		['doThumb'=>true, 'w'=>350, 'h'=>350, 'dst'=>'thumb']
		// 	];
		// 	foreach( $dt['img'] as $k=>$img){
		// 		$this->Images->uploader('img/categories_photos', $img, $fname.$k, $thumb_params);
		// 	}
        //     $sep = empty($rec->pro_photos) ? '' : ',';
		// 	$dt['pro_photos'] = $rec->pro_photos.$sep.$this->Images->getPhotosNames();
        // }

        // $dt['sales_configs'] = json_encode( !empty($dt['sales_configs']) ? $dt['sales_configs'] : ['icon'=>'', 'isProtected'=>''] );
        
        // $rec = $this->Sales->patchEntity($rec, $dt);
		
        // if ($newRec = $this->Sales->save($rec)) {
        //     echo json_encode(["status"=>"SUCCESS", "data"=>$newRec]); die();
        // }
        // echo json_encode(["status"=>"FAIL", "data"=>$rec->getErrors()]); die();


        $dt = json_decode(file_get_contents('php://input'), true);
        
        //edit mode
        if ($this->request->is(['patch', 'put'])) {
            $rec = $this->Sales->get($dt['id']);
            
        }

        // add mode
        if ($this->request->is(['post'])) {
            $dt['id'] = null;
            $dt['tar_tbl'] = $this->Do->get('targetTables')[$this->request->getParam('controller')];
// debug($dt);
        }

        if ($this->request->is(['post', 'patch', 'put'])) {
            $this->autoRender = false;

             $rec = $this->Sales->newEntity($dt);
            if ($newRec = $this->Sales->save($rec)) {
                echo json_encode(["status" => "SUCCESS", "data" => $this->Do->convertJson($newRec)]);
                die();
            }
        
            echo json_encode(["status" => "FAIL", "data" => $rec->getErrors()]);
            die();
        }
        
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
        $delRec = $this->Sales->deleteAll(['id IN ' => explode(",", $id)]);
        
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
            $dt= $this->Sales->newEmptyEntity();;
            $dt["id"] = $rec;
            $dt["rec_state"] = $val;
            if(!$this->Sales->save($dt)){
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
