<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UnavailabilitiesFixture
 */
class UnavailabilitiesFixture extends TestFixture
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
                'start_date' => '2024-09-07',
                'end_date' => '2024-09-07',
                'location_id' => 1,
            ],
        ];
        parent::init();
    }
}
