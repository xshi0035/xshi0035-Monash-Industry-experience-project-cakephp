<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BookingsPhotos Model
 *
 * @property \App\Model\Table\BookingsTable&\Cake\ORM\Association\BelongsTo $Bookings
 * @property \App\Model\Table\PhotosTable&\Cake\ORM\Association\BelongsTo $Photos
 *
 * @method \App\Model\Entity\BookingsPhoto newEmptyEntity()
 * @method \App\Model\Entity\BookingsPhoto newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BookingsPhoto> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BookingsPhoto get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BookingsPhoto findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BookingsPhoto patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BookingsPhoto> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BookingsPhoto|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BookingsPhoto saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BookingsPhoto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BookingsPhoto>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BookingsPhoto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BookingsPhoto> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BookingsPhoto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BookingsPhoto>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BookingsPhoto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BookingsPhoto> deleteManyOrFail(iterable $entities, array $options = [])
 */
class BookingsPhotosTable extends Table
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

        $this->setTable('bookings_photos');
        $this->setDisplayField('photo_type');
        $this->setPrimaryKey('id');

        $this->belongsTo('Bookings', [
            'foreignKey' => 'booking_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Photos', [
            'foreignKey' => 'photo_id',
            'joinType' => 'INNER',
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
            ->scalar('booking_id')
            ->maxLength('booking_id', 12)
            ->notEmptyString('booking_id');

        $validator
            ->integer('photo_id')
            ->notEmptyString('photo_id');

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
        $rules->add($rules->existsIn(['photo_id'], 'Photos'), ['errorField' => 'photo_id']);

        return $rules;
    }
}
