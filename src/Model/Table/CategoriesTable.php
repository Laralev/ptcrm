<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CategoriesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('categories');
        $this->setDisplayField('category_name');
        $this->setPrimaryKey('id');

        $this->belongsTo('ParentCategories', [
            'className' => 'Categories',
            'foreignKey' => 'parent_id',
        ]);
        
        $this->hasMany('ChildCategories', [
            'className' => 'Categories',
            'foreignKey' => 'parent_id',
        ]);

        
		$this->addBehavior('Log');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('language_id');

        $validator
            ->integer('parent_id')
            ->notEmptyString('parent_id');

        $validator
            ->scalar('category_name')
            ->maxLength('category_name', 255)
            ->requirePresence('category_name', 'create')
            ->notEmptyString('category_name');

        $validator
            ->scalar('category_configs')
            ->maxLength('category_configs', 255)
            ->allowEmptyString('category_configs');

        $validator
            ->allowEmptyString('category_priority');

        $validator
            ->allowEmptyString('rec_state');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        // $rules->add($rules->existsIn('parent_id', 'ParentCategories'), ['errorField' => 'parent_id']);

        return $rules;
    }
}
