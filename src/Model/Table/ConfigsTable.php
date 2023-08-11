<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ConfigsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('configs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        
		$this->addBehavior('Log');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('config_key')
            ->maxLength('config_key', 255)
            ->requirePresence('config_key', 'create')
            ->notEmptyString('config_key');

        $validator
            ->scalar('config_value')
            ->allowEmptyString('config_value');

        $validator
            ->dateTime('stat_updated')
            ->notEmptyDateTime('stat_updated');

        return $validator;
    }
}
