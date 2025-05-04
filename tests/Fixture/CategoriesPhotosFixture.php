<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CategoriesPhotosFixture
 */
class CategoriesPhotosFixture extends TestFixture
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
                'cat_id' => 1,
                'photo_id' => 1,
            ],
        ];
        parent::init();
    }
}
