<?php

namespace App\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;


/**
 * Users Model
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TeamsTable extends Table
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

        $this->belongsToMany('players',['joinTable' => 'team_players', 'dependent' => true, 'cascadeCallbacks' => true, ]);
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
            ->requirePresence('name', 'create', 'This is required parameter.')
            ->notEmpty('name', 'name is required.');

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
            $entity->modified   = date("Y-m-d H:i:s");
            
        $entity->modified   = date("Y-m-d H:i:s");

        return true;
    }

    public function __get($team_id)
    {   
        $team = $this->find()->where(['id' => $team_id])->contain(['players'])->toArray();

        if(!empty($team[0])) 
            return $team[0];

        return [];
        
    }                

    public function deleteTeams($team_id)
    {   
        if($this->find()->delete()->where(['id' => $team_id])->execute()) 
            return  1;

        return 0;
        
    }

}

