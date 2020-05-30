<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Biditem Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property bool $finished
 * @property \Cake\I18n\FrozenTime $endtime
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Bidinfo[] $bidinfo
 * @property \App\Model\Entity\Bidrequest[] $bidrequests
 */
class Biditem extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
		'name' => true,
		'detail' => true, //【機能追加】商品詳細を一括代入できるように
		'image' => true, //【機能追加】商品画像を一括代入できるように
        'finished' => true,
        'endtime' => true,
        'created' => true,
        'user' => true,
        'bidinfo' => true,
        'bidrequests' => true,
    ];
}
