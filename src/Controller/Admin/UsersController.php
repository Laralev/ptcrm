<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Datasource\ConnectionManager;

class UsersController extends AppController
{
    
    public function dashboard()
    {
        if ($this->request->is(['post'])) {
            
            $this->autoRender = false;
            echo json_encode([ "status"=>"SUCCESS", "data"=>[
                    'stats' => [],//$this->statistics(), 
                    'notifications' => [],//$this->notifications()
                ] 
            ]); die();

        }
    }

    private function statistics()
    {

        if($this->authUser["id"]){
            $conn = ConnectionManager::get('default');
            // NUMBERS
            $q_numbers = $conn->execute("
                SELECT
                    ( SELECT COUNT(*) FROM users u WHERE u.rec_state = 0 ) AS 'total_disabled_users',
                    ( SELECT COUNT(*) FROM users u WHERE u.rec_state = 1 ) AS 'total_enabled_users',

                    ( SELECT COUNT(*) FROM users u WHERE u.stat_lastlogin > DATE_SUB( curdate(), INTERVAL 1 WEEK) ) AS 'total_active_users',
                    ( SELECT COUNT(*) FROM users u WHERE u.stat_lastlogin < DATE_SUB( curdate(), INTERVAL 1 WEEK) ) AS 'total_inactive_users',

                    ( SELECT COUNT(*) FROM properties p WHERE p.stat_updated < DATE_SUB(curdate(), INTERVAL 1 MONTH) ) AS 'total_updated_properties',
                    ( SELECT COUNT(*) FROM properties p WHERE p.stat_updated > DATE_SUB(curdate(), INTERVAL 1 MONTH) ) AS 'total_outdated_properties',
                    ( SELECT COUNT(*) FROM properties p WHERE p.rec_state = 0 ) AS 'total_inactive_properties',
                    ( SELECT COUNT(*) FROM properties p WHERE p.rec_state = 1 ) AS 'total_active_properties',

                    ( SELECT COUNT(*) FROM projects pj WHERE pj.rec_state = 0 ) AS 'total_inactive_projects',
                    ( SELECT COUNT(*) FROM projects pj WHERE pj.rec_state = 1 ) AS 'total_active_projects',

                    ( SELECT COUNT(*) FROM sellers s ) AS 'total_sellers',

                    ( SELECT COUNT(*) FROM developers d ) AS 'total_developers',

                    ( SELECT COUNT(*) FROM offices o ) AS 'total_offices'

                FROM users u LIMIT 0, 1
            ")->fetchAll('assoc');

            // USERS 
            $q_users = $this->getTableLocator()->get('Users')->find('all', [
                'fields'=>['id', 'label'=>'user_fullname', 'user_role', 'stat_logins'
            ]])->toArray();

            $users = ['items'=>$q_users, 'labels'=>[], 'values'=>[]];
            $logins = ['items'=>$q_users, 'labels'=>[], 'values'=>[]];
            $logins['labels'] = array_values(array_column($q_users, 'label'));
            $logins['values'] = array_values(array_column($q_users, 'stat_logins'));

            foreach($users['items'] as &$user){
                $users['labels'][$user['user_role']] = __(empty($user['user_role']) ? '' : $user['user_role']);
                $users['values'][$user['user_role']] = empty($users['values'][$user['user_role']]) ? 1 : $users['values'][$user['user_role']] + 1;
                $user['total_values'][$user['user_role']] = empty($user['total_values'][$user['user_role']]) ? 1 : $user['total_values'][$user['user_role']]+1;
            }
            
            $users['labels'] = array_values($users['labels']);
            $users['values'] = array_values($users['values']);

            // PROPS PRICES
            
            $currCurrency = $this->Do->get('currencies')[ $this->currCurrency ];
            $currCurrency_icon = $this->Do->get('currencies_icons')[ $this->currCurrency ];
            $block = floor( $this->Do->currencyConverter("TRY", $currCurrency, 500000) );
            
            $prop_prices_q = $this->getTableLocator()->get('Properties')->find('all', [
                'conditions'=>['property_price >'=>0],
                'fields'=>['id', 'property_price', 'property_currency']
            ])->toArray();

            $prices=['items'=>[], 'values'=>[], 'labels'=>[]];
            foreach($prop_prices_q as &$itm){
                $from = $this->Do->get('currencies')[ empty($itm->property_currency) ? 3 : $itm->property_currency ];
                $itm->converted_price = floor( $this->Do->currencyConverter($from, $currCurrency, $itm->property_price) );
                $range_num = floor( $itm->converted_price / $block );
                $prices['values'][$range_num] = !isset($prices['values'][$range_num]) ? 1 : $prices['values'][$range_num]+1;
            }
            arsort($prices['values']);
            foreach($prices['values'] as $k=>$v){
                $prices['labels'][$k] = $currCurrency_icon.($block * ($k-1)).' - '.$currCurrency_icon.($block * ($k)).' '.$currCurrency;
            }
            
            $prices['values'] = array_values( $prices['values'] );
            $prices['labels'] = array_values( $prices['labels'] );

            // debug($prices);
            // debug(max( array_column( $prop_prices_q, 'converted_price') ));
            return [
                "numbers"=>$q_numbers[0],
                "users"=>$users,
                "logins"=>$logins,
                // "prop_prices"=>$prop_prices,
                "prices"=>$prices,
            ];

        }else{
            return [];
        }
    }

    private function notifications()
    {
        if($this->authUser["id"]){
            $conn = ConnectionManager::get('default');
            $lastlogin = $this->authUser['stat_lastlogin'];

            // SYSTEM ADMIN 
            if(in_array( $this->authUser['user_role'], ['admin.admin', 'admin.root'])){
                $q = $conn->execute("
                    SELECT 
                        u.id, u.user_fullname, 
                        
                        ( SELECT COUNT(*) FROM properties pp 
                            WHERE pp.stat_created >= \"$lastlogin\" ) AS 'new_properties', 
                        
                        ( SELECT COUNT(*) FROM projects pj 
                            WHERE pj.stat_created >= \"$lastlogin\" ) AS 'new_projects', 
                        
                        ( SELECT COUNT(*) FROM properties pp 
                            WHERE pp.stat_updated <= DATE_SUB('".date('Y-m-d')."', INTERVAL 1 MONTH) ) AS 'new_outdated_properties'
                        
                        FROM users u")->fetchAll('assoc');
                    
            }

            // PORTFOLIO OWNER
            if(in_array( $this->authUser['user_role'], ['admin.portfolio', 'admin.callcenter'])){
                $q = $conn->execute("
                    SELECT 
                        u.id, u.user_fullname, 
                        
                        ( SELECT COUNT(*) FROM properties pp 
                            WHERE pp.stat_updated <= DATE_SUB('".date('Y-m-d')."', INTERVAL 1 MONTH) AND 
                            pp.user_id = '".$this->authUser['id']."') AS 'new_outdated_properties'
                        
                        FROM users u")->fetchAll('assoc');
            }

            // SUPERVISOR
            if(in_array( $this->authUser['user_role'], ['admin.supervisor'])){
                
                $office_members_ids = $this->getTableLocator()->get('Users')->find('list', ['conditions'=>[
                    'office_id' => $this->authUser['office_id'],
                ]])->toArray();
                
                $q = $conn->execute("
                    SELECT 
                        u.id, u.user_fullname, 
                        
                        ( SELECT COUNT(*) FROM properties pp 
                            WHERE pp.stat_updated <= DATE_SUB('".date('Y-m-d')."', INTERVAL 1 MONTH) AND 
                            pp.user_id IN ( ".implode( ',', array_keys( $office_members_ids ) )." )) AS 'new_outdated_properties'
                        
                        FROM users u")->fetchAll('assoc');
                        
            }
            
            // CONTENT
            if(in_array( $this->authUser['user_role'], ['admin.content'])){
                $uid = $this->authUser['id'];
                // dd($uid);
                $q = $conn->execute("
                    SELECT 
                        u.id, u.user_fullname, 
                        
                        ( SELECT COUNT(*) FROM user_property up 
                            WHERE up.user_id = $uid AND up.rec_state = '1' ) AS 'new_properties', 
                        
                        ( SELECT COUNT(*) FROM user_project uj 
                            WHERE uj.user_id = $uid AND uj.rec_state = '1' ) AS 'new_projects'
                        
                        FROM users u")->fetchAll('assoc');
                        
            }
            
            $notifications = $q[0];
            
            // $notifications["total"]=0;
            // foreach($notifications as $k=>$itm){
            //     if(strpos($k, "new_")!==false){
            //         $notifications["total"]+=($itm*1);
            //     }
            // }
            // return $notifications;
            if(count($notifications)>2){
                return $notifications;
            }else{
                debug($q);
            }
        }else{
            return [];
        }
    }
    
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
    
            
            if( !empty($_from) ){ $conditions['Users.stat_created > '] = $_from; }
            if( !empty($_to) ){ $conditions['Users.stat_created < '] = $_to; }
            if($_k !== false){
                $_method == 'like' ?  $conditions[$_col.' LIKE '] = '%'.$_k.'%' : $conditions['Users.'.$_col] = $_k;
            }
            
            $data=[];
            $_id = $this->request->getQuery('id');
            $_list = $this->request->getQuery('list');

            // ONE RECORD
            if(!empty($_id)){
                $data = $this->Users->get( $_id )->toArray();
                echo json_encode(["status"=>"SUCCESS",  "data"=>$this->Do->convertJson( $data )], JSON_UNESCAPED_UNICODE); die();
            }

            // LIST
            if(!empty($_list)){ 
                $data = $this->paginate($this->Users, [
                    "order"=>[ $_col => $_dir ],
                    "conditions"=>$conditions,
                ]);

            }

            echo json_encode( 
                [ "status"=>"SUCCESS",  "data"=>$this->Do->convertJson( $data ), "paging"=>$this->Paginator->getPagingParams()["Users"]], 
                JSON_UNESCAPED_UNICODE); die();
        }
    }

    public function view($id = null)
    {
        $rec = $this->Users->get($id,[
            'contain' => ['Offices'=>['fields'=>['id', 'office_name']]]
        ]);
        $this->set(compact('rec'));
    }

    public function myaccount($id = -1) 
    {
    }

    public function save($id = -1) 
    {
        $dt = json_decode( file_get_contents('php://input'), true);

        // edit mode
        if ($this->request->is(['patch', 'put'])) {
            $rec = $this->Users->get($dt['id']);
            $oldEmail = $rec->email;
        }

        // add mode
        if ($this->request->is(['post'])) {
            $rec = $this->Users->newEmptyEntity();
            $dt['id'] = null;
            $dt['stat_created'] = date('Y-m-d H:i:s');
        }
        if ($this->request->is(['post', 'patch', 'put'])) {
            
            $this->autoRender  = false;

            $dt['user_configs'] = json_encode($dt['user_configs']);
            
            $rec = $this->Users->patchEntity($rec, $dt);
            unset($rec['office']);
            if ($newRec = $this->Users->save($rec)) {
                // send activation email in case email change or new account created
                if(!$dt['id'] || strtolower(trim($newRec->email)) != strtolower(trim($oldEmail))){
                    $this->Do->sendEmail([$newRec->email], __('new_account'), $newRec, 'register_tm');
                } 
                echo json_encode(["status"=>"SUCCESS", "data"=>$this->Do->convertJson( $newRec )]);
                die();
            }

            echo json_encode(["status"=>"FAIL", "data"=>$rec->getErrors()]); die();
        }
    }

	public function delimage() 
    {
        $this->request->allowMethod(['delete']);
        $ctrl = $this->request->getParam('controller');
        $this->autoRender  = false;
        $dt = json_decode( file_get_contents('php://input'), true);
        

		if( $this->Images->deleteFile('img/'.strtolower( $ctrl ).'_photos', $dt['image'])){
            $rec = $this->$ctrl->get($dt['id']);
            
			$imgsArray = explode(",", $rec->user_photos);
            $key = array_search($dt['image'], $imgsArray);
			unset($imgsArray[$key]);
			$update = ["id"=>$dt['id'], "user_photos"=>implode(",",$imgsArray)];
        	$updated_rec = $this->$ctrl->patchEntity($rec, $update);
			$saved = $this->$ctrl->save($updated_rec);
            echo json_encode(["status"=>"SUCCESS", "data"=>$saved]);  die();
		}else{
            echo json_encode(["status"=>"FAIL", "data"=>$dt]); die();
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

        $delRec=[];
        foreach(explode(",", $id) as $k=>$rec_id){
            $rec = $this->Users->get($rec_id);
            $delRec[$k] = $this->Users->delete($rec);
        }
        
        $res = (!empty(array_filter($delRec))) ? ["status"=>"SUCCESS", "data"=>$delRec] : ["status"=>"FAIL", "data"=>$delRec];

        echo json_encode($res);die();

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

        $updateRec=[];
        foreach(explode(',', $ids) as $k=>$id){
            $rec = $this->Users->newEmptyEntity();
            $rec['id'] = $id;
            $rec['rec_state'] = $val;
            $updateRec[$k] = $this->Users->save($rec);
        }
        
        $res = (!empty(array_filter($updateRec))) ? ["status"=>"SUCCESS", "data"=>$updateRec] : ["status"=>"FAIL", "data"=>$updateRec];

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