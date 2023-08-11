<?php
declare(strict_types=1);

namespace App\Controller;

class UsersController extends AppController
{

    public function login() 
    {
        $this->autoRender = false;
        $dt = json_decode(file_get_contents('php://input'), true);
        
		if ($this->request->is('post')) {

            // login using remember_me user id
            if(!empty( $this->Do->CookiesHandler('RMMBRME_ID') ) ){
                
                $user = $this->Users->find('all', [
                    'conditions'=>[ 'id'=>$this->Do->CookiesHandler('RMMBRME_ID') ]
                ] )->first()->toArray();
                
                if(!$user){ return $this->logout(); }

            // login from email AUTOLOGIN for activation and change password
            }elseif(isset($dt['autologin'])){
                $code = base64_decode( $dt['autologin'] );
                $id = substr($code , 3, -3);
                $user = $this->Users->get($id)->toArray();
                
            // login normally
            }else{
                $user = $this->Auth->identify();
            }

            // if auth fail 
            if (!$user) { 
                echo json_encode(['status'=>'FAIL', 'data'=>$user]); die(); 
            }else{
                
                // check if account activated  
                if ($user['rec_state'] == 0 && !isset($dt['autologin'])) {
                    echo json_encode(['status'=>'NOT_ACTIVE', 'data'=>$user]); die();
                }

                // update and activate record then do log user in 
                $updt = [
                    'id'=>$user['id'], 
                    'stat_lastlogin'=>date('Y-m-d H:i:s'), 
                    'stat_logins'=>$user['stat_logins']+1,
                    'rec_state'=>1
                ];

                if( $this->Do->adder( $updt, 'Users') ){
                    $this->Auth->setUser($this->Do->convertJson( $user ));

                    // save remember me id variable into cookie
                    if( !empty( $dt['remember_me'] ) ){
                        $this->Do->CookiesHandler(['RMMBRME_ID'=>$user['id']], 'write');
                    }
                    
                    // check if there is redirect value
                    if ( !empty( $dt['changePassword'] ) ) {
                        echo json_encode(['status'=>'SUCCESS', 'data'=>$user, 'redirect'=>$this->app_folder.'/admin/myaccount?msg='.__('change_password')]); die();
                    }

                    // tell user activition succeed
                    if ($user['rec_state'] == 0 && isset($dt['autologin'])) {
                        echo json_encode(['status'=>'SUCCESS', 'data'=>$user, 'redirect'=>$this->app_folder.'/?activate=1']); die();
                    }
                    echo json_encode(['status'=>'SUCCESS', 'data'=>$user]); die();
                }else{
                    echo json_encode(['status'=>'FAIL', 'data'=>$user, 'updt'=>$updt]); die();
                }
            }

            
		}
    }
	
    public function logout() 
    {
        $this->autoRender = false;
        // if( !empty( $this->Auth->User("id") ) ){
            $this->Do->CookiesHandler('RMMBRME_ID', 'delete');
            return $this->redirect($this->Auth->logout());
        // }
    }
    
    public function register() 
    {
		if(!empty($this->Auth->User('id')) && $this->Auth->User('role') !== 'root'){
			$this->Flash->error(__('one_account_allowed'));
			$this->redirect(['controller'=>'Users', 'action'=>'dashboard']);
		}
		
		$user = $this->Users->newEntity(['associated'=>['Schools'] ]);
        if ($this->request->is('post')) {
            
            $this->autoRender = false;
            $userDT = json_decode(file_get_contents('php://input'), true);
                
			$userDT['stat_created'] = date("Y-m-d H:i:s");
			$userDT['stat_lastlogin'] = date("Y-m-d H:i:s");
			$userDT['user_role'] = 'user.admin';
			$userDT['stat_ip'] = $_SERVER['REMOTE_ADDR'];
			$userDT['rec_state'] = 0;
			$userDT['user_token'] = base64_encode($user->email.'-'.$user->password);

			// $user = $this->Users->newEntity($user);
			$user = $this->Users->patchEntity($user, $userDT );
			// debug($user);
			// die();
            if ($newRec = $this->Users->save($user )) {
                $newRec->lang = $this->currlang;
				if($this->Do->sendEmail([$newRec->email], __('new_account'), $newRec, 'register_tm')){
                    if(@$_GET['ajax'] == 1){echo json_encode(["status"=>"SUCCESS"]); die ;}
                    $this->Flash->success(__('send-success'));
                }else{
                    if(@$_GET['ajax'] == 1){echo json_encode(["status"=>"FAIL"]); die ;}
                    $this->Flash->error(__('send-fail'));
                }
            }else{
				if(@$_GET['ajax'] == 1){echo json_encode($user->getErrors());die();}
                $this->Flash->error(__('register-fail'));
			}
        }
		if(@$_GET['ajax'] == 1){
			return json_encode($user);
		}else{
			$this->set(compact('user'));
			$this->set('_serialize', ['user']);
		}
    }
	
	public function activate($code=null, $changePassword=null)
    {
		$this->autoRender = false;
        
        $id = substr( base64_decode( $code ), 3,  -3);

		$checkUser = $this->Users->find('all',['conditions'=>['id'=>$id]])->first();

		if(!$checkUser){
			$this->Flash->error(__('expired_link'));
			return $this->redirect('/');
		}else{
			$user = $this->Users->newEntity();
			$user->id = $checkUser->id;
			$user->rec_state = '1';
			$user->user_token = '1';
			$user->stat_lastlogin = date('Y-m-d H:i:s');
			if($this->Users->save($user)){
				$this->Flash->success(__('account_activated'));
                if($changePassword){
                    $this->redirect(["controller"=>"Users", "action"=>"edit", $checkUser->id]);
                }
			}else{
				$this->Flash->error(__('error_activated_msg'));
			}
			$this->redirect("/?login=1");
		}
	}
	
	public function getpassword($code = null)
    {
        $this->autoRender = false;

		if ($this->request->is('post')) {

            $dt = json_decode(file_get_contents('php://input'), true);
            if(!filter_var($dt['email'], FILTER_VALIDATE_EMAIL)){
                echo json_encode(['status'=>'FAIL', 'msg'=>__('is-email-msg'), 'data'=>[]]); die();
            }
            $checkUser = $this->Users->findByEmail( $dt['email'] )->first();
            if(empty($checkUser)){
                $this->Flash->error(__('email_not_found'));
            }
            
            $checkUser['user_token'] = $this->Do->setPW(32,0);
            $checkUser['app_folder'] = $this->app_folder;
            
            $user = $this->Users->newEmptyEntity();
            $user->id = $checkUser['id'];
            $user->user_token = $checkUser['user_token'];
            if( $this->Users->save($user) ){
                if($this->Do->sendEmail([$dt['email']], __('new_password_subject'), $checkUser, 'getpassword_tm')){
                    echo json_encode(['status'=>'SUCCESS', 'data'=>$user]); die();
                }else{
                    echo json_encode(['status'=>'FAIL', 'data'=>$user]); die();
                }
            }
        }

        $this->set('user', $user);
	}
    
    
    public function edit() 
    {
        if($this->request->getQuery('changepw')==1){
            $this->Flash->default(__('please_change_your_password'));
        }
    }
    
}
