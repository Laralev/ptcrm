<?php

namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;

class IncBehavior extends Behavior {
	
	public function beforeFind($event, $entity) {
		$params = Router::getRequest()->params;
        $increasable = ["Exams", "Polls", "Scores", "Competitions"];
        // debug($params);die();
		if(
            in_array($params['action'],['view','game']) && 
            empty($params['prefix']) && 
            in_array($params["controller"], $increasable)
        ){
			$tbl = !empty($params['?']['matchid']) ? 'matches' : strtolower( $params["controller"] );
			$col = !empty($params['slug']) && empty($params['?']['matchid']) ? 'slug' : 'id';

			if( !empty($params['pass'][0]) ){ $val = $params['pass'][0] ; }
			if( !empty($params['?']['matchid']) ){ $val = $params['?']['matchid'] ; }
			if( !empty($params['id']) ){ $val = $params['id'] ; }
			if( !empty($params['slug']) ){ $val = $params['slug'] ; }

			// debug($col);
			// debug($val);
			// debug($params);
			// die();

			if(!$val){return ;}

            $q = "UPDATE $tbl SET stat_views = stat_views + 1 WHERE $col = '".$val."'";
			$connection = ConnectionManager::get('default');
			return $connection->execute($q);
		}
    }
}