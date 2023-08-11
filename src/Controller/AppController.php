<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\I18n\I18n;


class AppController extends Controller
{

    
    public $authUser=null;
    public $authClient =null;

    public function initialize(): void
    {
        parent::initialize();

        $this->app_folder = Configure::read('app_folder');
        $this->isLocal = Configure::read('isLocal');
        $this->protocol = $this->isLocal ? 'http' : 'https';
        $this->path = $this->protocol.'://'.env('SERVER_NAME'). $this->app_folder;

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        $this->loadComponent('Images');
        $this->loadComponent('Do');
        $this->loadComponent('Paginator');
		$this->loadComponent('Auth',[
            // 'authorize' => ['Controller'],
            'authError' => __('not_allowed'),
            'storage' => 'Session',
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'unauthorizedRedirect' => $this->referer(),
            'authenticate' => [
                    'Form' => [
                        'contain'=>['Profiles'],
                        'userModel' => 'Users',
                        'fields' => [
                            'username' => 'email',
                            'password' => 'password',
                        ]
                    ]
                ],
            'loginAction' => '/?login=1',
            'logoutRedirect' => '/',
            'authError' => __('not_allowed'), 
		]);

        $this->Auth->deny();
		
		$this->Auth->allow(['login', 'register', 'logout', 'display', 'getpassword', 'activate']);
		
		if(!empty($this->request->getParam('prefix'))){
            if(empty($this->Auth->User('id'))){
                $this->Auth->deny();
            }else{
                $this->paginate = [ 'limit' => 20 ];
                $this->viewBuilder()->setLayout('admin');
                $this->Auth->deny();
                $this->Auth->allow(['index', 'view', 'logout']);
            }
		}
        
		//check and set language
        $langval='en';
        $cookieLang = $this->Do->CookiesHandler('lang', 'read');
        $urlLang = $this->request->getParam('lang');
        if( empty( $this->request->getParam('prefix') ) ){
            if( empty($urlLang) ){
                if( empty($cookieLang) ){
                    $langval = $this->Do->getMachineLang($_SERVER['HTTP_ACCEPT_LANGUAGE']);
                    $this->Do->CookiesHandler(['lang'=>$langval], 'write');
                }else{
                    $langval =  $this->Do->CookiesHandler('lang', 'read');
                }
            }else{
                $langval = $urlLang;
                $this->Do->CookiesHandler(['lang'=>$langval], 'write');
            }
        }
        $langval='en';//force to english language
		I18n::setLocale($langval);
		$this->currlang = $langval ;
		$this->currlangid = $this->Do->get('languages_ids')[$langval] ;
        
		//check and set currency
        $currencyval=1;
        $cookieCurrency = $this->Do->CookiesHandler('currency', 'read');
        if( empty($cookieCurrency) ){
            $this->Do->CookiesHandler(['currency'=>$currencyval], 'write');
        }else{
            $currencyval =  $this->Do->CookiesHandler('currency', 'read');
        }
		$this->currCurrency = $currencyval ;
    }

    private function _getAction()
    {
		$act = $this->request->getParam('action');
		$crud = 'read';
		switch($act){
			case strpos($act, 'login') !== false :
			case strpos($act, 'logout') !== false :
			case strpos($act, 'register') !== false :
				$crud = 'public';
			break;
			case strpos($act, 'index') !== false :
			case strpos($act, 'view') !== false :
				$crud = 'read';
			break;
			case strpos($act, 'add') !== false  :
				$crud = 'create';
			break;
			case strpos($act, 'edit') !== false  :
			case strpos($act, 'save') !== false  :
			case strpos($act, 'wizard') !== false  :
				$crud = 'update';
			break;
			case strpos($act, 'delete') !== false  :
				$crud = 'delete';
			break;
			default :
				$crud = 'public';
		}
		
		return $crud;
	}
	
	public function _isAuthorized($bool=false, $action=false)
    {
        if($this->request->getQuery('ajax') == 1){
            $bool=true;
        }
        
		$crud = !$action ? $this->_getAction() : $action;
		if(!empty($this->Auth->User())){
            $_role = $this->Auth->User('user_role');
			$_roles = Configure::read('ROLES');
            $_ctrl = strtolower($this->request->getParam('controller'));
			$isAllowed = @$_roles[ $_role ][ $_ctrl ][ $crud ];
            
            // if($this->request->getParam('prefix') == 'admin'){
			// 	$isAllowed = 0;
			// }

			if($isAllowed == 0 && $crud !== 'public'){
                if($bool){
                    return false;
                }else{
                    return $this->Flash->error(__('you_not_authorized'));
                }
				$this->redirect("/".$this->currlang);
			}
            if($bool){return true;}
		}
	}

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        if($this->Auth->User()){
            $this->authUser = $this->Auth->User();
        }else{
            $this->authUser = null;
        }
        
		if(@$_GET['mode'] == 'debug'){
			Configure::write('debug', true);
		}
		
        // Check Admin
		if($this->request->getParam('prefix') == 'admin'){
			$this->viewBuilder()->getLayout('admin');
		}
        
        $metaDt = [ 
            "_title"=>__('website_title'), 
            "_keywords"=>__('website_keywords'), 
            "_description"=>__('website_description'), 
            "_photo"=>"/img/website_img.jpg" 
        ];

        $currency_ratios = $this->getTableLocator()->get('Configs')->find('list', [
            'conditions'=>['config_key LIKE'=>'%_USD%'],
            'keyField' => 'config_key',
            'valueField' => 'config_value'
        ])->toArray();
        
        $mainDt = [
            "site_main_title"=>__('site_main_title'), 
            "current_url"=>$this->request->getAttribute('here'), 
            "server_url"=>$this->app_folder.'/'
        ];
        
        $metaDt = [ 
            "_title"=>__('website_title'), 
            "_keywords"=>__('website_keywords'), 
            "_description"=>__('website_description'), 
            "_photo"=>"/img/website_img.jpg" 
        ];
        
        $this->set("currency_ratios", $currency_ratios); 
        $this->set("currCurrency", $this->currCurrency);
        $this->set("mainDt", $mainDt); 
        $this->set("metaDt", $metaDt); 
		$this->set('isLocal', $this->isLocal);
		$this->set('protocol', $this->protocol);
		$this->set('path', $this->path);
		$this->set('currlang', $this->currlang);
		$this->set('currlangid', $this->currlangid);
		$this->set('authUrl', $this->app_folder.$this->Auth->redirectUrl());
		$this->set('app_folder', $this->app_folder);
        $this->set("authUser", $this->authUser);
        $this->set("gmapKey", Configure::read('gmapKey'));
        $this->set("isRememberMe", $this->Do->CookiesHandler('RMMBRME'));
	}

    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);
        $_Token =  $this->request->getAttribute('csrfToken');
        
		if(!empty( $this->request->getParam('prefix') )){
            $this->ViewBuilder()->setLayout('Admin');
        }
        
		if(!empty( $this->request->getQuery('theme')  == '1')){
            $this->ViewBuilder()->setTheme($this->request->getQuery('theme'));
            $this->ViewBuilder()->setLayout($this->request->getQuery('theme'));
        }
        
        // $this->ViewBuilder()->setTheme('Theme1');
        // $this->ViewBuilder()->setLayout('Theme1');
            


        $this->set("_Token", $_Token);
    }
}
