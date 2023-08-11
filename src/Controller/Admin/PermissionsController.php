<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

class PermissionsController extends AppController
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
                $conditions['Permissions.source_id'] = $_pid;
            }
            if(strlen($_k) > 0){
                if( $_method == 'like'){
                    $conditions[$_col.' LIKE '] = '%'.$_k.'%';
                }else{
                    $conditions[$_col] = is_numeric( $_k ) ? $_k*1 : $_k;
                }
            }

          

            
            $permissions = $this->paginate($this->Permissions);
            

            $conditions = [ ];

            // Filters and Search
            $_from = !empty($_GET['from']) ? $_GET['from'] : '';
            $_to = !empty($_GET['to']) ? $_GET['to'] : '';

            $_method = !empty($_GET['method']) ? $_GET['method'] : '';
            $_col = !empty($_GET['col']) ? $_GET['col'] : 'id';
            $_k = (isset($_GET['k']) && strlen($_GET['k'])>0) ? $_GET['k'] : false;

            $_dir = !empty($_GET['direction']) ? $_GET['direction'] : 'DESC';

            if($_k !== false){

                $_method == 'like' ?  $conditions[$_col.' LIKE '] = '%'.$_k.'%' : $conditions['Permissions.'.$_col] = $_k;  // note = $col condition is not correct 
                
            }
            
            $data=[];
            $_id = $this->request->getQuery('id');
            $_list = $this->request->getQuery('list');

            
            // ONE RECORD
            if(!empty($_id)){
                $data = $this->Permissions-> get( $_id )->toArray();
                //dd( $data);
                echo json_encode(["status"=>"SUCCESS",  "data"=>$this->Do->convertJson( $data )], JSON_UNESCAPED_UNICODE); die();
                
            }
            
            // LIST
            if(!empty($_list)){ 
                $data = $this->paginate($this->Permissions, [
                    "order"=>[ $_col => $_dir ],
                    "conditions"=>$conditions,
                    "limit"=>12,
                ]);

            }
             
            echo json_encode( 
                [ "status"=>"SUCCESS",  "data"=>$this->Do->convertJson( $data, $permissions ), "paging"=>$this->Paginator->getPagingParams()["Permissions"]], 
                JSON_UNESCAPED_UNICODE); die();
        }

    }
    
    public function view($id = null)
    {
        $rec = $this->Permissions->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('rec'));
        
        
        
       
    }
  
    public function add()
    {
        // $permissions = $this->Permissions->newEmptyEntity();
        // if ($this->request->is('post')) {
        //     $cats = explode("::", $this->request->getData('permission_id') );
        //     $data = [];
        //     foreach($cats as $k=>$cat){
        //         $data[$k] = $this->request->getData();
        //         $data[$k]["permission_id"] = $cat;
        //         $data[$k]["permissions_configs"] = json_encode($this->request->getData('permissions_configs'));
        //         $data[$k]["slug"] = $this->Do->slugger($cat);
        //         $data[$k]["rec_state"] = 1;
        //     }
        //     $permissions = $this->Permissions->patchEntities($permissions, $data);
        //     if ($this->Permissions->saveMany($permissions)) {
        //         $this->Flash->success(__('save-success'));
        //         return $this->redirect($this->referer());
        //     }else{
        //         $this->Flash->error(__('save-fail'));
        //     }
        // }
        // $parents = $this->Permissions->ParentPermissions->find('list', [
        //     'conditions' => ['source_id'=> empty($_GET['source_id']) ? 0 : $_GET['source_id'] ]
        // ]);
        // $languages = $this->Do->lcl( $this->Do->get('langs'));
        // $this->set(compact('permissions', 'parents', 'languages'));

        $dt = json_decode(file_get_contents('php://input'), true);
        
        if ($this->request->is(['patch', 'put'])) {
            $rec = $this->Permissions->get($dt['id']);
        }

        // add mode
        if ($this->request->is(['post'])) {
            $dt['id'] = null;
        }

        if ($this->request->is(['post', 'patch', 'put'])) {
            $this->autoRender = false;

            $rec = $this->Permissions->newEntity($dt);
            if ($newRec = $this->Permissions->save($rec)) {
                echo json_encode(["status" => "SUCCESS", "data" => $this->Do->convertJson($newRec)]);
                die();
            }

            echo json_encode(["status" => "FAIL", "data" => $rec->getErrors()]);
            die();
        }
    }
    
    
    public function save($id = -1) 
    {


        $dt = json_decode(file_get_contents('php://input'), true);
        
        // edit mode
        if ($this->request->is(['patch', 'put'])) {

            $rec = $this->Permissions->get($dt['id']);
            $rec = $this->Permissions->patchEntity( $rec,$dt);
// dd($rec);

        }
        // add mode
        if ($this->request->is(['post'])) {
            $dt['id'] = null;
            $rec = $this->Permissions->newEntity($dt);
        }

        if ($this->request->is(['post', 'patch', 'put'])) {
            $this->autoRender = false;
            if ($newRec = $this->Permissions->save($rec)) {           

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

        $delRec = $this->Permissions->deleteAll(['id IN ' => explode(",", $id)]);
        
        if ($delRec) {
            $res = ["status"=>"SUCCESS", "data"=>$delRec];
        }else{
            $res = ["status"=>"FAIL", "data"=>$delRec->getErrors()];
        }
        echo json_encode($res);die();

        return $this->redirect(['action' => 'index']);
    }
    
    public function enable($ids=null)
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
            $dt= $this->Permissions->newEmptyEntity();;
            $dt["id"] = $rec;
            if(!$this->Permissions->save($dt)){
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
