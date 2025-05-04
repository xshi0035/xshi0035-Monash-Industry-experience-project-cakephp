<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BookingsPhoto Entity
 *
 * @property int $id
 * @property string $photo_type
 * @property string|null $comments
 * @property string $booking_id
 * @property int $photo_id
 *
 * @property \App\Model\Entity\Booking $booking
 * @property \App\Model\Entity\Photo $photo
 */
class BookingsPhoto extends Entity
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
        'photo_type' => true,
        'comments' => true,
        'booking_id' => true,
        'photo_id' => true,
        'booking' => true,
        'photo' => true,
    ];
}
