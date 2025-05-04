<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
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
                'email' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'first_name' => 'Lorem ipsum dolor sit amet',
                'last_name' => 'Lorem ipsum dolor sit amet',
                'phone_no' => 'Lorem ip',
                'role_id' => 1,
                'nonce' => 'Lorem ipsum dolor sit amet',
                'nonce_expiry' => '2024-08-12 11:16:00',
                'created' => '2024-08-12 11:16:00',
                'modified' => '2024-08-12 11:16:00',
            ],
        ];
        parent::init();
    }
}
