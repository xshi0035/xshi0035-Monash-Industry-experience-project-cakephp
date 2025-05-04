<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Photos Model
 *
 * @method \App\Model\Entity\Photo newEmptyEntity()
 * @method \App\Model\Entity\Photo newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Photo> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Photo get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Photo findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Photo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Photo> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Photo|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Photo saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Photo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Photo>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Photo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Photo> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Photo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Photo>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Photo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Photo> deleteManyOrFail(iterable $entities, array $options = [])
 */
class PhotosTable extends Table
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

        $this->setTable('photos');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->belongsToMany('BookingsServices', [
            'foreignKey' => 'photo_id',
            'targetForeignKey' => 'bookings_service_id',
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
            ->scalar('name')
            ->maxLength('name', 128)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('path')
            ->maxLength('path', 250)
            ->requirePresence('path', 'create')
            ->notEmptyString('path');

        return $validator;
    }
}
