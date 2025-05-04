<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Booking Entity
 *
 * @property string $id
 * @property string $total_cost
 * @property string $discount_amount
 * @property string $initial_amount
 * @property \Cake\I18n\Time $dropoff_time
 * @property \Cake\I18n\Date $dropoff_date
 * @property int $status_id
 * @property \Cake\I18n\DateTime $date_paid
 * @property \Cake\I18n\DateTime $date_booked
 * @property \Cake\I18n\Date|null $due_date
 * @property int $cust_id
 * @property int $location_id
 * @property int|null $user_id
 *
 * @property \App\Model\Entity\Status $status
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Photo[] $photos
 * @property \App\Model\Entity\Product[] $products
 * @property \App\Model\Entity\Service[] $services
 */
class Booking extends Entity
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
        'total_cost' => true,
        'discount_amount' => true,
        'initial_amount' => true,
        'dropoff_time' => true,
        'dropoff_date' => true,
        'status_id' => true,
        'date_paid' => true,
        'date_booked' => true,
        'due_date' => true,
        'cust_id' => true,
        'location_id' => true,
        'user_id' => true,
        'status' => true,
        'customer' => true,
        'location' => true,
        'user' => true,
        'photos' => true,
        'products' => true,
        'services' => true,
    ];
}
