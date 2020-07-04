<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Bidcontact Entity
 *
 * @property int $id
 * @property int $bidinfo_id
 * @property int $user_id
 * @property string $zip
 * @property string $address
 * @property string $phone_number
 * @property bool $send
 * @property bool $receipt
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\Bidinfo $bidinfo
 * @property \App\Model\Entity\User $user
 */
class Bidcontact extends Entity
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
        'user_id' => true,
        'zip' => true,
        'address' => true,
        'phone_number' => true,
        'send' => true,
        'receipt' => true,
        'created' => true,
        'bidinfo' => true,
        'user' => true,
    ];
}
