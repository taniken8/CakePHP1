<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Bidreview Entity
 *
 * @property int $id
 * @property int $review_user_id
 * @property int $user_id
 * @property int $rate
 * @property string $comment
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\ReviewUser $review_user
 * @property \App\Model\Entity\User $user
 */
class Bidreview extends Entity
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
		'bidinfo_id' => true,
		'review_user_id' => true,
        'user_id' => true,
        'rate' => true,
        'comment' => true,
        'created' => true,
        'review_user' => true,
        'user' => true,
    ];
}
