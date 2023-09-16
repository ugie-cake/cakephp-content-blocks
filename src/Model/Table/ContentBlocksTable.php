<?php
declare(strict_types=1);

namespace ContentBlocks\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContentBlocks Model
 *
 * @method \ContentBlocks\Model\Entity\ContentBlock newEmptyEntity()
 * @method \ContentBlocks\Model\Entity\ContentBlock newEntity(array $data, array $options = [])
 * @method \ContentBlocks\Model\Entity\ContentBlock[] newEntities(array $data, array $options = [])
 * @method \ContentBlocks\Model\Entity\ContentBlock get($primaryKey, $options = [])
 * @method \ContentBlocks\Model\Entity\ContentBlock findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ContentBlocks\Model\Entity\ContentBlock patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ContentBlocks\Model\Entity\ContentBlock[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ContentBlocks\Model\Entity\ContentBlock|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ContentBlocks\Model\Entity\ContentBlock saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ContentBlocks\Model\Entity\ContentBlock[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ContentBlocks\Model\Entity\ContentBlock[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ContentBlocks\Model\Entity\ContentBlock[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ContentBlocks\Model\Entity\ContentBlock[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ContentBlocksTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('content_blocks');
        $this->setDisplayField('display_field');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('parent')
            ->maxLength('parent', 128)
            ->requirePresence('parent', 'create')
            ->notEmptyString('parent');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 256)
            ->requirePresence('slug', 'create')
            ->notEmptyString('slug');

        $validator
            ->scalar('type')
            ->maxLength('type', 32)
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->scalar('value')
            ->requirePresence('value', 'create')
            ->notEmptyString('value');

        return $validator;
    }
}
