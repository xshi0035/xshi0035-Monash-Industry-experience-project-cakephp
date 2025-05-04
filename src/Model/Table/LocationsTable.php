<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Locations Model
 *
 * @property \App\Model\Table\StatesTable&\Cake\ORM\Association\BelongsTo $States
 * @property \App\Model\Table\AvailabilitiesTable&\Cake\ORM\Association\HasMany $Availabilities
 * @property \App\Model\Table\BookingsTable&\Cake\ORM\Association\HasMany $Bookings
 * @property \App\Model\Table\UnavailabilitiesTable&\Cake\ORM\Association\HasMany $Unavailabilities
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \App\Model\Entity\Location newEmptyEntity()
 * @method \App\Model\Entity\Location newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Location> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Location get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Location findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Location patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Location> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Location|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Location saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Location>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Location>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Location>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Location> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Location>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Location>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Location>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Location> deleteManyOrFail(iterable $entities, array $options = [])
 */
class LocationsTable extends Table
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

        $this->setTable('locations');
        $this->setDisplayField('street_no');
        $this->setPrimaryKey('id');

        $this->belongsTo('States', [
            'foreignKey' => 'state_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Availabilities', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasMany('Bookings', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasMany('Unavailabilities', [
            'foreignKey' => 'location_id',
        ]);
        $this->belongsToMany('Services', [
            'foreignKey' => 'location_id',
            'targetForeignKey' => 'service_id',
            'joinTable' => 'locations_services',
        ]);
        $this->belongsToMany('Users', [
            'foreignKey' => 'location_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'locations_users',
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
            ->scalar('name')
            ->maxLength('name', 128)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('st_address')
            ->maxLength('st_address', 128)
            ->requirePresence('st_address', 'create')
            ->notEmptyString('st_address');

        $validator
            ->scalar('suburb')
            ->maxLength('suburb', 128)
            ->requirePresence('suburb', 'create')
            ->notEmptyString('suburb');

        $validator
            ->scalar('postcode')
            ->maxLength('postcode', 4)
            ->requirePresence('postcode', 'create')
            ->notEmptyString('postcode');

        $validator
            ->integer('state_id')
            ->notEmptyString('state_id');

        $validator
            ->decimal('latitude')
            ->allowEmptyString('latitude');

        $validator
            ->decimal('longitude')
            ->allowEmptyString('longitude');

        $validator
            ->scalar('status')
            ->notEmptyString('status');

        $validator
            ->integer('turnaround')
            ->requirePresence('turnaround', 'create')
            ->notEmptyString('turnaround');

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
        $rules->add($rules->existsIn(['state_id'], 'States'), ['errorField' => 'state_id']);

        return $rules;
    }
}
