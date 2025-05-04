<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AvailabilitiesFixture
 */
class AvailabilitiesFixture extends TestFixture
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
                'start_time' => '10:26:28',
                'end_time' => '10:26:28',
                'day_of_week' => 1,
                'location_id' => 1,
            ],
        ];
        parent::init();
    }
}
