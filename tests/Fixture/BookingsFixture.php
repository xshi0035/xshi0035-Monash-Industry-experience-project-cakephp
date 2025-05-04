<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BookingsFixture
 */
class BookingsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '',
                'total_cost' => 1.5,
                'discount_amount' => 1.5,
                'initial_amount' => 1.5,
                'dropoff_time' => '22:10:49',
                'dropoff_date' => '2024-09-28',
                'status_id' => 1,
                'date_paid' => '2024-09-28 22:10:49',
                'date_booked' => '2024-09-28 22:10:49',
                'due_date' => '2024-09-28',
                'cust_id' => 1,
                'location_id' => 1,
                'user_id' => 1,
            ],
        ];
        parent::init();
    }
}
