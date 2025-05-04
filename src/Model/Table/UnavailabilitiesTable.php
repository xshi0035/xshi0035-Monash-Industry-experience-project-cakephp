<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Unavailabilities Model
 *
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 *
 * @method \App\Model\Entity\Unavailability newEmptyEntity()
 * @method \App\Model\Entity\Unavailability newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Unavailability> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Unavailability get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Unavailability findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Unavailability patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Unavailability> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Unavailability|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Unavailability saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Unavailability>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Unavailability>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Unavailability>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Unavailability> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Unavailability>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Unavailability>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Unavailability>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Unavailability> deleteManyOrFail(iterable $entities, array $options = [])
 */
class UnavailabilitiesTable extends Table
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

        $this->setTable('unavailabilities');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
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
            ->date('start_date')
            ->requirePresence('start_date', 'create')
            ->notEmptyDate('start_date');

        $validator
            ->date('end_date')
            ->requirePresence('end_date', 'create')
            ->notEmptyDate('end_date');

        $validator
            ->integer('location_id')
            ->notEmptyString('location_id');

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

        return $rules;
    }
}
