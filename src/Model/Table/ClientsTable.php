<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ClientsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('clients');
        $this->setDisplayField('client_name');
        $this->setPrimaryKey('id');

        $this->hasMany('ClientSpecs', [
            'foreignKey' => 'client_id',
            'className' => 'ClientSpecs',
            'joinType' => 'INNER',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);

        $this->hasMany('Reports', [
            'foreignKey' => 'tar_id',
            'joinType' => 'INNER',
			'dependent' => true,
			'cascadeCallbacks' => true
        ])->setConditions(['Reports.tar_tbl'=>'Clients']);
        
		$this->addBehavior('Log');
    }

    public function validationDefault(Validator $validator): Validator
    {
        // $validator
        //     ->scalar('client_name')
        //     ->maxLength('client_name', 255)
        //     ->requirePresence('client_name', 'create')
        //     ->notEmptyString('client_name');

        // $validator
        //     ->dateTime('stat_created')
        //     ->notEmptyDateTime('stat_created');

        // $validator
        //     ->scalar('spec_name')
        //     ->maxLength('spec_name', 255)
        //     ->requirePresence('spec_name', 'create')
        //     ->notEmptyString('spec_name');

        // $validator
        //     ->scalar('client_token')
        //     ->maxLength('client_token', 255)
        //     ->requirePresence('client_token', 'create')
        //     ->notEmptyString('client_token');

        // $validator
        //     ->scalar('client_configs')
        //     ->maxLength('client_configs', 255)
        //     ->requirePresence('client_configs', 'create')
        //     ->notEmptyString('client_configs');

        // $validator
        //     ->dateTime('stat_lastlogin')
        //     ->requirePresence('stat_lastlogin', 'create')
        //     ->notEmptyDateTime('stat_lastlogin');

        // $validator
        //     ->dateTime('stat_created')
        //     ->requirePresence('stat_created', 'create')
        //     ->notEmptyDateTime('stat_created');

        // $validator
        //     ->integer('stat_logins')
        //     ->requirePresence('stat_logins', 'create')
        //     ->notEmptyString('stat_logins');

        // $validator
        //     ->scalar('stat_ip')
        //     ->maxLength('stat_ip', 255)
        //     ->requirePresence('stat_ip', 'create')
        //     ->notEmptyString('stat_ip');

        // $validator
        //     ->boolean('rec_state')
        //     ->requirePresence('rec_state', 'create')
        //     ->notEmptyString('rec_state');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);

        return $rules;
    }
}
