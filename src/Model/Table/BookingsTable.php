<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Bookings Model
 *
 * @property \App\Model\Table\StatusesTable&\Cake\ORM\Association\BelongsTo $Statuses
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\PhotosTable&\Cake\ORM\Association\BelongsToMany $Photos
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsToMany $Products
 * @property \App\Model\Table\ServicesTable&\Cake\ORM\Association\BelongsToMany $Services
 *
 * @method \App\Model\Entity\Booking newEmptyEntity()
 * @method \App\Model\Entity\Booking newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Booking> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Booking get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Booking findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Booking patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Booking> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Booking|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Booking saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Booking>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Booking>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Booking>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Booking> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Booking>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Booking>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Booking>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Booking> deleteManyOrFail(iterable $entities, array $options = [])
 */
class BookingsTable extends Table
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

        $this->setTable('bookings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Statuses', [
            'foreignKey' => 'status_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'cust_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsToMany('Photos', [
            'foreignKey' => 'booking_id',
            'targetForeignKey' => 'photo_id',
            'joinTable' => 'bookings_photos',
        ]);
        $this->belongsToMany('Products', [
            'foreignKey' => 'booking_id',
            'targetForeignKey' => 'product_id',
            'joinTable' => 'bookings_products',
        ]);
        $this->belongsToMany('Services', [
            'foreignKey' => 'booking_id',
            'targetForeignKey' => 'service_id',
            'joinTable' => 'bookings_services',
        ]);
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
            ->decimal('total_cost')
            ->requirePresence('total_cost', 'create')
            ->notEmptyString('total_cost');

        $validator
            ->decimal('discount_amount')
            ->notEmptyString('discount_amount');

        $validator
            ->decimal('initial_amount')
            ->notEmptyString('initial_amount');

        $validator
            ->time('dropoff_time')
            ->requirePresence('dropoff_time', 'create')
            ->notEmptyTime('dropoff_time');

        $validator
            ->date('dropoff_date')
            ->requirePresence('dropoff_date', 'create')
            ->notEmptyDate('dropoff_date');

        $validator
            ->integer('status_id')
            ->notEmptyString('status_id');

        $validator
            ->dateTime('date_paid')
            ->notEmptyDateTime('date_paid');

        $validator
            ->dateTime('date_booked')
            ->notEmptyDateTime('date_booked');

        $validator
            ->date('due_date')
            ->allowEmptyDate('due_date');

        $validator
            ->integer('cust_id')
            ->notEmptyString('cust_id');

        $validator
            ->integer('location_id')
            ->notEmptyString('location_id');

        $validator
            ->integer('user_id')
            ->allowEmptyString('user_id');

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
        $rules->add($rules->existsIn(['status_id'], 'Statuses'), ['errorField' => 'status_id']);
        $rules->add($rules->existsIn(['cust_id'], 'Customers'), ['errorField' => 'cust_id']);
        $rules->add($rules->existsIn(['location_id'], 'Locations'), ['errorField' => 'location_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
