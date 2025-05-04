<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Location Entity
 *
 * @property int $id
 * @property string $name
 * @property string $st_address
 * @property string $suburb
 * @property string $postcode
 * @property int $state_id
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string $status
 * @property int $turnaround
 *
 * @property \App\Model\Entity\State $state
 * @property \App\Model\Entity\Availability[] $availabilities
 * @property \App\Model\Entity\Booking[] $bookings
 * @property \App\Model\Entity\Unavailability[] $unavailabilities
 * @property \App\Model\Entity\User[] $users
 */
class Location extends Entity
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
        'st_address' => true,
        'suburb' => true,
        'postcode' => true,
        'state_id' => true,
        'latitude' => true,
        'longitude' => true,
        'status' => true,
        'turnaround' => true,
        'state' => true,
        'availabilities' => true,
        'bookings' => true,
        'unavailabilities' => true,
        'users' => true,
    ];
}
