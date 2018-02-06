<?php

namespace App\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PlayerTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
;
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param Validator $validator Validator instance.
     * @return Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('steam_name', 'create', 'This is required parameter.')
            ->notEmpty('steam_name', 'steam_name is required.');

        return $validator;
    }

    /**
     * Default validation rules.
     *
     * @param Validator $validator Validator instance.
     * @return Validator
     */
    public function validationLoginApi(Validator $validator)
    {
        $validator
            ->requirePresence('id', 'create', 'This is required parameter.')
            ->notEmpty('id', 'id is required');

        return $validator;
    }

    /**
     * Modifies password before saving into database
     *
     * @param Event $event Event
     * @param EntityInterface $entity Entity
     * @param ArrayObject $options Array of options
     * @return bool
     */
    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        if(empty($entity->created))
            $entity->created   = date("Y-m-d H:i:s");
            
        $entity->modified   = date("Y-m-d H:i:s");

        return true;
    }

    public function __get($player_id)
    {   
        $player = $this->find()->where(['id' => $player_id])->toArray();

        if(!empty($player[0])) 
            return $player[0];

        return [];
        
    }

}

