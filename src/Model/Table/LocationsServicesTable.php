<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LocationsServices Model
 *
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\ServicesTable&\Cake\ORM\Association\BelongsTo $Services
 *
 * @method \App\Model\Entity\LocationsService newEmptyEntity()
 * @method \App\Model\Entity\LocationsService newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\LocationsService> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LocationsService get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\LocationsService findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LocationsService patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\LocationsService> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LocationsService|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LocationsService saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\LocationsService>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LocationsService>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LocationsService>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LocationsService> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LocationsService>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LocationsService>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LocationsService>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LocationsService> deleteManyOrFail(iterable $entities, array $options = [])
 */
class LocationsServicesTable extends Table
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

        $this->setTable('locations_services');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Services', [
            'foreignKey' => 'service_id',
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
            ->integer('location_id')
            ->notEmptyString('location_id');

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
        $rules->add($rules->existsIn(['location_id'], 'Locations'), ['errorField' => 'location_id']);
        $rules->add($rules->existsIn(['service_id'], 'Services'), ['errorField' => 'service_id']);

        return $rules;
    }
}
