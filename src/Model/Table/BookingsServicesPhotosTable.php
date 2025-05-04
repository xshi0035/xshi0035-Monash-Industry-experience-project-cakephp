<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BookingsServicesPhotos Model
 *
 * @property \App\Model\Table\BookingsServicesTable&\Cake\ORM\Association\BelongsTo $BookingsServices
 * @property \App\Model\Table\PhotosTable&\Cake\ORM\Association\BelongsTo $Photos
 *
 * @method \App\Model\Entity\BookingsServicesPhoto newEmptyEntity()
 * @method \App\Model\Entity\BookingsServicesPhoto newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BookingsServicesPhoto> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BookingsServicesPhoto get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BookingsServicesPhoto findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BookingsServicesPhoto patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BookingsServicesPhoto> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BookingsServicesPhoto|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BookingsServicesPhoto saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BookingsServicesPhoto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BookingsServicesPhoto>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BookingsServicesPhoto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BookingsServicesPhoto> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BookingsServicesPhoto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BookingsServicesPhoto>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BookingsServicesPhoto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BookingsServicesPhoto> deleteManyOrFail(iterable $entities, array $options = [])
 */
class BookingsServicesPhotosTable extends Table
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

        $this->setTable('bookings_services_photos');
        $this->setDisplayField('photo_type');
        $this->setPrimaryKey('id');

        $this->belongsTo('BookingsServices', [
            'foreignKey' => 'bookings_service_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Photos', [
            'foreignKey' => 'photo_id',
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
            ->scalar('photo_type')
            ->requirePresence('photo_type', 'create')
            ->notEmptyString('photo_type');

        $validator
            ->scalar('comments')
            ->allowEmptyString('comments');

        $validator
            ->integer('booking_service_id')
            ->notEmptyString('booking_service_id');

        $validator
            ->integer('photo_id')
            ->allowEmptyString('photo_id');

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
        $rules->add($rules->existsIn(['booking_service_id'], 'BookingsServices'), ['errorField' => 'booking_service_id']);
        $rules->add($rules->existsIn(['photo_id'], 'Photos'), ['errorField' => 'photo_id']);

        return $rules;
    }
}
