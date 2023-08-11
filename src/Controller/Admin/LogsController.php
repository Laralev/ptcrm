<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\EventInterface;

class LogsController extends AppController
{
    
    public function index( )
    {

        if ($this->request->is('post')) {

            $this->autoRender = false;

            $conditions = [ ];

            // Filters and Search
            $_from = !empty($_GET['from']) ? $_GET['from'] : '';
            $_to = !empty($_GET['to']) ? $_GET['to'] : '';

            $_method = !empty($_GET['method']) ? $_GET['method'] : '';
            $_col = !empty($_GET['col']) ? $_GET['col'] : 'id';
            $_k = (isset($_GET['k']) && strlen($_GET['k'])>0) ? $_GET['k'] : false;
            $_dir = !empty($_GET['direction']) ? $_GET['direction'] : 'DESC';
    
            
            if( !empty($_from) ){ $conditions['Logs.stat_created > '] = $_from; }
            if( !empty($_to) ){ $conditions['Logs.stat_created < '] = $_to; }
            if($_k !== false){
                $_method == 'like' ?  $conditions[$_col.' LIKE '] = '%'.$_k.'%' : $conditions['Logs.'.$_col] = $_k;
            }
            
            $data=[];
            $_id = $this->request->getQuery('id');
            $_list = $this->request->getQuery('list');

            // ONE RECORD
            if(!empty($_id)){
                $data = $this->Logs->get( $_id , [
                    'contain'=>['Users'=>['fields'=>['user_fullname']]]
                ])->toArray();
                $data = $this->Do->convertJson($data);
                echo json_encode( 
                    [ "status"=>"SUCCESS",  "data"=>$this->Do->convertJson( $data )], 
                    JSON_UNESCAPED_UNICODE); die();
            }

            // LIST
            if(!empty($_list)){ 
                $data = $this->paginate($this->Logs, [
                    "order"=>[ $_col => $_dir ],
                    "conditions"=>$conditions,
                    "contain"=>["Users"=>["fields"=>["user_fullname", "user_role"]]],
                ]);
                $data = $this->Do->convertJson($data);
                // foreach($data as &$itm){
                //     $itm['log_url'] = explode("/", str_replace($this->app_folder, "", $itm['log_url']));
                // }
            }

            echo json_encode( 
                [ "status"=>"SUCCESS",  "data"=>$data, "paging"=>$this->Paginator->getPagingParams()["Logs"]], 
                JSON_UNESCAPED_UNICODE); die();
        }

    }

    public function view($id = null)
    {
        $rec = $this->Logs->get( $id, [
            'contain'=>['Users'=>['fields'=>['user_fullname']]]
        ] );
        // debug($rec->toArray());
        $rec->log_url = json_decode( $rec->log_url, true );
        $rec->log_changes = json_decode( trim(preg_replace('/\s\s+/', ' ', $rec->log_changes)), true );
        $this->set(compact('rec'));
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
        $delRec = $this->Logs->deleteAll(['id IN ' => explode(",", $id)]);
        
        if ($delRec) {
            $res = ["status"=>"SUCCESS", "data"=>$delRec];
        }else{
            $res = ["status"=>"FAIL", "data"=>$delRec->getErrors()];
        }
        echo json_encode($res);die();

    }
    
    function beforeFilter(EventInterface $event) 
    {
        parent::beforeFilter($event);
        
        if ($this->request->is(['post', 'patch', 'put', 'delete'])) {
            if(!$this->_isAuthorized(true, 'read')){
                echo json_encode(["status" => "FAIL", "redirect" => $this->app_folder.'/?login=1']); die();
            }
        }
    }
}