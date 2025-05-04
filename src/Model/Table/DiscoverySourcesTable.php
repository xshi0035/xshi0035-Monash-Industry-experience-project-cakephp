<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DiscoverySources Model
 *
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\HasMany $Customers
 *
 * @method \App\Model\Entity\DiscoverySource newEmptyEntity()
 * @method \App\Model\Entity\DiscoverySource newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\DiscoverySource> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DiscoverySource get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\DiscoverySource findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\DiscoverySource patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\DiscoverySource> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DiscoverySource|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\DiscoverySource saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\DiscoverySource>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DiscoverySource>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DiscoverySource>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DiscoverySource> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DiscoverySource>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DiscoverySource>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DiscoverySource>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DiscoverySource> deleteManyOrFail(iterable $entities, array $options = [])
 */
class DiscoverySourcesTable extends Table
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

        $this->setTable('discovery_sources');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Customers', [
            'foreignKey' => 'discovery_source_id',
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
            ->maxLength('name', 250)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        return $validator;
    }
}
