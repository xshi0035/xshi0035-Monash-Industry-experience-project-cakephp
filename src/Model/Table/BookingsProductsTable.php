<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BookingsProducts Model
 *
 * @property \App\Model\Table\BookingsTable&\Cake\ORM\Association\BelongsTo $Bookings
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \App\Model\Entity\BookingsProduct newEmptyEntity()
 * @method \App\Model\Entity\BookingsProduct newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BookingsProduct> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BookingsProduct get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BookingsProduct findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BookingsProduct patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BookingsProduct> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BookingsProduct|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BookingsProduct saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BookingsProduct>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BookingsProduct>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BookingsProduct>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BookingsProduct> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BookingsProduct>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BookingsProduct>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BookingsProduct>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BookingsProduct> deleteManyOrFail(iterable $entities, array $options = [])
 */
class BookingsProductsTable extends Table
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

        $this->setTable('bookings_products');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Bookings', [
            'foreignKey' => 'booking_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
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
            ->integer('product_qty')
            ->requirePresence('product_qty', 'create')
            ->notEmptyString('product_qty');

        $validator
            ->scalar('booking_id')
            ->maxLength('booking_id', 12)
            ->notEmptyString('booking_id');

        $validator
            ->integer('product_id')
            ->notEmptyString('product_id');

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
        $rules->add($rules->existsIn(['product_id'], 'Products'), ['errorField' => 'product_id']);

        return $rules;
    }
}
