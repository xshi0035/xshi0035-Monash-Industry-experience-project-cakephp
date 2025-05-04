<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LocationsService Entity
 *
 * @property int $id
 * @property int $location_id
 * @property int $service_id
 *
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\Service $service
 */
class LocationsService extends Entity
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
        'location_id' => true,
        'service_id' => true,
        'location' => true,
        'service' => true,
    ];
}
