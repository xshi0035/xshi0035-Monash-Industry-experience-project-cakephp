<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BookingsServicesFixture
 */
class BookingsServicesFixture extends TestFixture
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
                'id' => 1,
                'service_qty' => 1,
                'booking_id' => '',
                'service_id' => 1,
            ],
        ];
        parent::init();
    }
}
