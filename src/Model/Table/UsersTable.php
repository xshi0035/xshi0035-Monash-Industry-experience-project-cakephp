<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsToMany $Locations
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\User> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\User> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('email');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsToMany('Locations', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'location_id',
            'joinTable' => 'locations_users',
        ]);

        $this->addBehavior('CanAuthenticate');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('password')
            ->maxLength('password', 96)
            ->requirePresence('password', 'create')
            ->notEmptyString('password')
            ->add('password', [
                'length' => [
                    'rule' => ['minLength', 8],
                    'message' => 'Password must be at least 8 characters long',
                ],
                'upperCase' => [
                    'rule' => function ($value, $context) {
                        return (bool)preg_match('/[A-Z]/', $value);
                    },
                    'message' => 'Password must contain at least one uppercase letter',
                ],
                'number' => [
                    'rule' => function ($value, $context) {
                        return (bool)preg_match('/[0-9]/', $value);
                    },
                    'message' => 'Password must contain at least one number',
                ]
            ]);


        // $validator
        //     ->scalar('first_name')
        //     ->maxLength('first_name', 128)
        //     ->requirePresence('first_name', 'create')
        //     ->notEmptyString('first_name');

        // $validator
        //     ->scalar('last_name')
        //     ->maxLength('last_name', 128)
        //     ->requirePresence('last_name', 'create')
        //     ->notEmptyString('last_name');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 50, 'First name must be no longer than 50 characters.')
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name', 'Please enter your first name.')
            ->add('first_name', 'custom', [
                'rule' => ['custom', '/^[a-zA-Z\- ]{1,50}$/'],
                'message' => 'First name must contain only letters, hyphens, and spaces, and must be no longer than 50 characters.'
            ]);

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 50, 'Last name must be no longer than 50 characters.')
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name', 'Please enter your last name.')
            ->add('last_name', 'custom', [
                'rule' => ['custom', '/^[a-zA-Z\- ]{1,50}$/'],
                'message' => 'Last name must contain only letters, hyphens, and spaces, and must be no longer than 50 characters.'
            ]);

        $validator
            ->scalar('phone_no')
            ->maxLength('phone_no', 10)
            ->requirePresence('phone_no', 'create')
            ->notEmptyString('phone_no');

        $validator
            ->integer('role_id')
            ->notEmptyString('role_id');

        $validator
            ->scalar('nonce')
            ->maxLength('nonce', 255)
            ->allowEmptyString('nonce');

        $validator
            ->dateTime('nonce_expiry')
            ->allowEmptyDateTime('nonce_expiry');

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
        $rules->add($rules->existsIn(['role_id'], 'Roles'), ['errorField' => 'role_id']);

        return $rules;
    }
}
