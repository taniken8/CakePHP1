<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Bidcontacts Model
 *
 * @property \App\Model\Table\BidinfosTable&\Cake\ORM\Association\BelongsTo $Bidinfos
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Bidcontact newEmptyEntity()
 * @method \App\Model\Entity\Bidcontact newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Bidcontact[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Bidcontact get($primaryKey, $options = [])
 * @method \App\Model\Entity\Bidcontact findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Bidcontact patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Bidcontact[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Bidcontact|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Bidcontact saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Bidcontact[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Bidcontact[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Bidcontact[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Bidcontact[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BidcontactsTable extends Table
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

        $this->setTable('bidcontacts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Bidinfo', [
            'foreignKey' => 'bidinfo_id',
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
            ->scalar('zip')
            ->maxLength('zip', 255)
            ->requirePresence('zip', 'create')
            ->notEmptyString('zip', '郵便番号を入力してください')
            ->add('zip', 'custom',[
                'message' => '〒○○○-○○○○の形式で入力してください',
                'rule' => function ($value, $context) {
                    return (bool) preg_match('/^([0-9]{3})(-[0-9]{4})?$/i', $value);
                }
            ]);

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->requirePresence('address', 'create')
            ->notEmptyString('address', '住所を入力してください');

        $validator
            ->scalar('phone_number')
            ->maxLength('phone_number', 255)
            ->requirePresence('phone_number', 'create')
            ->notEmptyString('phone_number', '電話番号を入力してください')
            ->add('phone_number', 'custom', [
                'message' => '000-1111-2222の形式で入力してください',
                'rule' => function ($value) {
                    return (bool) preg_match('/^0\d{2,3}-\d{1,4}-\d{4}$/', $value);
                }
            ]);

        $validator
            ->boolean('send')
            ->requirePresence('send', 'create')
            ->notEmptyString('send');

        $validator
            ->boolean('receipt')
            ->requirePresence('receipt', 'create')
            ->notEmptyString('receipt');

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
        $rules->add($rules->existsIn(['bidinfo_id'], 'Bidinfo'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
