<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LocationsFixture
 */
class LocationsFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'st_address' => 'Lorem ipsum dolor sit amet',
                'suburb' => 'Lorem ipsum dolor sit amet',
                'postcode' => '',
                'state_id' => 1,
                'latitude' => 1.5,
                'longitude' => 1.5,
                'status' => 'Lorem ipsum dolor sit amet',
                'turnaround' => 1,
            ],
        ];
        parent::init();
    }
}
