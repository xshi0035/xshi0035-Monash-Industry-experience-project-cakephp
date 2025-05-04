<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Availability Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time $start_time
 * @property \Cake\I18n\Time $end_time
 * @property int $day_of_week
 * @property int $location_id
 *
 * @property \App\Model\Entity\Location $location
 */
class Availability extends Entity
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
        'start_time' => true,
        'end_time' => true,
        'day_of_week' => true,
        'location_id' => true,
        'location' => true,
    ];
}
