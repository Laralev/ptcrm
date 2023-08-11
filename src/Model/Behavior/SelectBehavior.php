<?php

namespace App\Model\Behavior;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Behavior;
use Cake\Event\Event;
use Cake\I18n\I18n;
use Cake\Core\Configure;
use Cake\Routing\Router;

class SelectBehavior extends Behavior {
   
	public function setup($model, $config = array()) {
        $this->settings[$model->alias] = array_merge($this->_defaults, (array) $config);
    }
	
	public function beforeFind($event, $query, $options, $primary) {
		$tbl_name = explode('\\', $event->getSubject()->getEntityClass());
		$tbl = $event->getSubject()->getAlias();
		$params = Router::getRequest();
        //debug($params);
		if(@$params->getParam('prefix') !== 'admin'){
            //|| !in_array( $params['action'], ['index', 'view'])
			//$languages = array_flip(Configure::read('LANGUAGES_IDS'));
			$query->where([
					$tbl.'.rec_state' => 1,
					//$tbl.'.language_id' => $languages[I18n::locale()]
				]);//->order([$tbl.'.'.end($tbl_name).'_priority, '.$tbl.'.id ASC']);
		}
		return $query;
    }
}