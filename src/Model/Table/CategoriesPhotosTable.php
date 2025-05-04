<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CategoriesPhotos Model
 *
 * @property \App\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\PhotosTable&\Cake\ORM\Association\BelongsTo $Photos
 *
 * @method \App\Model\Entity\CategoriesPhoto newEmptyEntity()
 * @method \App\Model\Entity\CategoriesPhoto newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CategoriesPhoto> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CategoriesPhoto get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CategoriesPhoto findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CategoriesPhoto patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CategoriesPhoto> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CategoriesPhoto|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CategoriesPhoto saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CategoriesPhoto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CategoriesPhoto>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CategoriesPhoto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CategoriesPhoto> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CategoriesPhoto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CategoriesPhoto>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CategoriesPhoto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CategoriesPhoto> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CategoriesPhotosTable extends Table
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

        $this->setTable('categories_photos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Categories', [
            'foreignKey' => 'cat_id',
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
            ->integer('cat_id')
            ->notEmptyString('cat_id');

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
        $rules->add($rules->existsIn(['cat_id'], 'Categories'), ['errorField' => 'cat_id']);
        $rules->add($rules->existsIn(['photo_id'], 'Photos'), ['errorField' => 'photo_id']);

        return $rules;
    }
}
