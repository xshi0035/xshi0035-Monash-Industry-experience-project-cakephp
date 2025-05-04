<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BookingsProductsFixture
 */
class BookingsProductsFixture extends TestFixture
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
                'product_qty' => 1,
                'booking_id' => '',
                'product_id' => 1,
            ],
        ];
        parent::init();
    }
}
