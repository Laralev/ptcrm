<?php

namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Query;

class LogBehavior extends Behavior {
    
    // public function initialize(array $config): void
    // {
    //     $params = Router::getRequest(); 
    //     if( in_array($params->getParam('action'), ['enable', 'delete']) && $params->getServerParams()['ORIGINAL_REQUEST_METHOD'] == 'DELETE'){
    //         $this->doLog(null);
    //     }
    // }
    
	public function afterDelete(EventInterface $event, EntityInterface $entity, ArrayObject $options) 
    {
        $this->doLog($entity);
    }
	public function afterSave(EventInterface $event, EntityInterface $entity, ArrayObject $options) 
    {
        $this->doLog($entity);
    }

    private function doLog($entity)
    {
        $params = Router::getRequest();
        if($params->getParam('action') == 'index'){return false;}
        
        $origonal = !empty($entity) ? $entity->getOriginalValues() : [];

        // debug($params->getData());
        // debug($entity->getOriginalValues());
        // debug($entity->getDirty());
        // debug($entity->get($entity->getDirty()));
        // debug($entity);
        // die();

        $authUser = $params->getParam('action') == 'login' ? ['id'=>$origonal['id']] : Router::getRequest()->getSession()->read('Auth.User');
        $data = $params->getData();
        $data['id'] = isset($data['id']) ? $data['id'] : null;
        $before = [];
        $after = [];
        $pass = $params->getParam('pass');

        $actn = $params->getParam('action');
        $actn = $actn == 'enable' ? ($pass[0] == 1 ? 'enable' : 'disable') : $actn;
        $actn = $actn == 'save' ? ($data['id'] == -1 ? 'save_new' : 'update') : $actn;
        
        // Login logs
        if($params->getParam('action') == 'login'){
            $after = ['user_fullname'=>$origonal['user_fullname'], 'user_role'=>__($origonal['user_role'])];

        // Send Messages logs
        }elseif($params->getParam('controller') == 'Messages'){
            $after = [
                'message_text'=>preg_replace( "/\r|\n/", "", strip_tags(@$data['message_text'])), 
                'parent_id'=>!empty($data['parent_id']) ? $data['parent_id'] : 0,
                'sender'=>$authUser['user_fullname']
            ];
            
        // All other logs
        }else{
            if($params->getParam('action') == 'save'){
                // debug($params->getData());
                // debug($entity->getDirty());
                // die();
                // Update logs
                if($data['id'] > 0){
                    foreach($entity->getDirty() as $itm){
                        if(isset($data[$itm])){
                            if( is_object( $data[$itm] ) || is_array( $data[$itm] )){ $data[$itm] = __('object'); }
                        }
                        if(isset($origonal[$itm])){
                            if( is_object( $origonal[$itm] ) || is_array( $origonal[$itm] )){ $origonal[$itm] = __('object'); }
                        }
                        
                        $before[$itm] = intval($data['id'])>0 ? $origonal[$itm] : '';
                        $after[$itm] = isset($data[$itm]) ? $data[$itm] : '';
                    }

                // New insert logs
                }else{
                    $dirty = implode(",",$entity->getDirty());
                    foreach($data as $key=>$itm){
                        if( strpos($dirty, $key) === false ){ continue; }
                        $after[$key] = $itm;
                    }
                }
            // special action / enable / delete / delimage
            }else{
                $after = [__($actn) => !empty($pass) ? $pass[count($pass)-1]:''  ];
            }
        }

        $before = empty($before) ? false : json_encode($before, JSON_UNESCAPED_UNICODE); 
        $after = json_encode($after, JSON_UNESCAPED_UNICODE);
        $changes = $before ? "[".$before.", ".$after."]" : "[".$after."]"; 
        
        $url  = json_encode([
                "",
                "",
                "",
                "",
                $params->getServerParams()['REQUEST_SCHEME'].'//:'.$params->getServerParams()['SERVER_NAME'].$params->getServerParams()['REQUEST_URI'],
                $params->getParam('controller'),
                $actn ,
                !empty($pass) ? $pass[count($pass)-1] : ""
        ]);
        
        $data = [
            "user_id"=>empty($authUser['id']) ? null : $authUser['id'], 
            "log_url"=>$url,
            "log_changes"=>$changes
        ];
        $q = "
            INSERT INTO logs(". implode(",", array_keys($data) ) .") 
            VALUES ('". implode("','", array_values($data) ) ."');
            ";
        $connection = ConnectionManager::get('default');
        return $connection->execute($q);
    }

}