<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PhotosProducts Model
 *
 * @property \App\Model\Table\PhotosTable&\Cake\ORM\Association\BelongsTo $Photos
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \App\Model\Entity\PhotosProduct newEmptyEntity()
 * @method \App\Model\Entity\PhotosProduct newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\PhotosProduct> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PhotosProduct get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\PhotosProduct findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\PhotosProduct patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\PhotosProduct> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PhotosProduct|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\PhotosProduct saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\PhotosProduct>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PhotosProduct>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PhotosProduct>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PhotosProduct> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PhotosProduct>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PhotosProduct>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PhotosProduct>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PhotosProduct> deleteManyOrFail(iterable $entities, array $options = [])
 */
class PhotosProductsTable extends Table
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

        $this->setTable('photos_products');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Photos', [
            'foreignKey' => 'photo_id',
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
            ->integer('photo_id')
            ->notEmptyString('photo_id');

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
        $rules->add($rules->existsIn(['photo_id'], 'Photos'), ['errorField' => 'photo_id']);
        $rules->add($rules->existsIn(['product_id'], 'Products'), ['errorField' => 'product_id']);

        return $rules;
    }
}
