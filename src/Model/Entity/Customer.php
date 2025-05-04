<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property int $id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $phone_no
 * @property int|null $discovery_source_id
 * @property string|null $admin_comments
 *
 * @property \App\Model\Entity\DiscoverySource $discovery_source
 */
class Customer extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'email' => true,
        'first_name' => true,
        'last_name' => true,
        'phone_no' => true,
        'discovery_source_id' => true,
        'admin_comments' => true,
        'discovery_source' => true,
    ];
}
