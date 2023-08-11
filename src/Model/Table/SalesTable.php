<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class SalesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('sales');
        $this->setDisplayField('client_id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
            'className' => 'Clients',
            'joinType' => 'INNER',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->hasMany('ClientSpecs', [
            'foreignKey' => 'client_id',
            'className' => 'ClientSpecs',
            'joinType' => 'INNER',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->belongsTo('Segements', [
            'foreignKey' => 'segement_id',
            'className' => 'Categories',
            'joinType' => 'INNER',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->belongsTo('Sources', [
            'foreignKey' => 'source_id',
            'className' => 'Categories',
            'joinType' => 'INNER',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->belongsTo('Pools', [
            'foreignKey' => 'pool_id',
            'className' => 'Categories',
            'joinType' => 'INNER',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->hasMany('Reports', [
            'foreignKey' => 'tar_id',
            'joinType' => 'INNER',
			'dependent' => true,
			'cascadeCallbacks' => true
        ])->setConditions(['Reports.tar_tbl'=>'Sales']);
        
		$this->addBehavior('Log');
    }

    public function validationDefault(Validator $validator): Validator
    {
        // $validator
        //     ->integer('client_id')
        //     ->notEmptyString('client_id');

        // $validator
        //     ->integer('parent_id')
        //     ->notEmptyString('parent_id');

        // $validator
        //     ->integer('source_id')
        //     ->notEmptyString('source_id');
        
        // $validator
        //     ->integer('segment_id')
        //     ->notEmptyString('segment_id');

        // $validator
        //     ->allowEmptyString('sale_current_stage');

        // $validator
        //     ->allowEmptyString('lead_priority');

        // $validator
        //     ->allowEmptyString('rec_state');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        // $rules->add($rules->existsIn('parent_id', 'ParentSales'), ['errorField' => 'parent_id']);

        return $rules;
    }
}
