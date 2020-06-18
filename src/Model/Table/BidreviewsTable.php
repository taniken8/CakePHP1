<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Bidreviews Model
 *
 * @property \App\Model\Table\ReviewUsersTable&\Cake\ORM\Association\BelongsTo $ReviewUsers
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Bidreview newEmptyEntity()
 * @method \App\Model\Entity\Bidreview newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Bidreview[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Bidreview get($primaryKey, $options = [])
 * @method \App\Model\Entity\Bidreview findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Bidreview patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Bidreview[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Bidreview|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Bidreview saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Bidreview[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Bidreview[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Bidreview[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Bidreview[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BidreviewsTable extends Table
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

        $this->setTable('bidreviews');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ReviewUsers', [
            'foreignKey' => 'review_user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('rate')
            ->requirePresence('rate', 'create')
            ->notEmptyString('rate');

        $validator
            ->scalar('comment')
            ->maxLength('comment', 255)
            ->requirePresence('comment', 'create')
            ->notEmptyString('comment');

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
        $rules->add($rules->existsIn(['review_user_id'], 'ReviewUsers'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
