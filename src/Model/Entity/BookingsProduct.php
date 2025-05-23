<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BookingsProduct Entity
 *
 * @property int $id
 * @property int $product_qty
 * @property string $booking_id
 * @property int $product_id
 *
 * @property \App\Model\Entity\Booking $booking
 * @property \App\Model\Entity\Product $product
 */
class BookingsProduct extends Entity
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
        'product_qty' => true,
        'booking_id' => true,
        'product_id' => true,
        'booking' => true,
        'product' => true,
    ];
}
