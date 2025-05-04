<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BookingsServices Model
 *
 * @property \App\Model\Table\BookingsTable&\Cake\ORM\Association\BelongsTo $Bookings
 * @property \App\Model\Table\ServicesTable&\Cake\ORM\Association\BelongsTo $Services
 * @property \App\Model\Table\PhotosTable&\Cake\ORM\Association\BelongsToMany $Photos
 *
 * @method \App\Model\Entity\BookingsService newEmptyEntity()
 * @method \App\Model\Entity\BookingsService newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BookingsService> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BookingsService get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BookingsService findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BookingsService patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BookingsService> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BookingsService|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BookingsService saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BookingsService>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BookingsService>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BookingsService>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BookingsService> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BookingsService>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BookingsService>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BookingsService>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BookingsService> deleteManyOrFail(iterable $entities, array $options = [])
 */
class BookingsServicesTable extends Table
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

        $this->setTable('bookings_services');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Bookings', [
            'foreignKey' => 'booking_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Services', [
            'foreignKey' => 'service_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsToMany('Photos', [
            'foreignKey' => 'bookings_service_id',
            'targetForeignKey' => 'photo_id',
            'joinTable' => 'bookings_services_photos',
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
            ->integer('service_qty')
            ->notEmptyString('service_qty');

        $validator
            ->scalar('booking_id')
            ->maxLength('booking_id', 12)
            ->notEmptyString('booking_id');

        $validator
            ->integer('service_id')
            ->notEmptyString('service_id');

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
        $rules->add($rules->existsIn(['booking_id'], 'Bookings'), ['errorField' => 'booking_id']);
        $rules->add($rules->existsIn(['service_id'], 'Services'), ['errorField' => 'service_id']);

        return $rules;
    }
}
