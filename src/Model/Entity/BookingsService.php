<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BookingsService Entity
 *
 * @property int $id
 * @property int $service_qty
 * @property string $booking_id
 * @property int $service_id
 *
 * @property \App\Model\Entity\Booking $booking
 * @property \App\Model\Entity\Service $service
 * @property \App\Model\Entity\Photo[] $photos
 */
class BookingsService extends Entity
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
        'service_qty' => true,
        'booking_id' => true,
        'service_id' => true,
        'booking' => true,
        'service' => true,
        'photos' => true,
    ];
}
