<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Service Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $service_cost
 * @property bool $archived
 * @property int $cat_id
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Booking[] $bookings
 */
class Service extends Entity
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
        'name' => true,
        'description' => true,
        'service_cost' => true,
        'archived' => true,
        'cat_id' => true,
        'category' => true,
        'bookings' => true,
    ];
}
