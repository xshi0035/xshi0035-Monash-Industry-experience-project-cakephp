<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BookingsServicesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BookingsServicesTable Test Case
 */
class BookingsServicesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BookingsServicesTable
     */
    protected $BookingsServices;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.BookingsServices',
        'app.Bookings',
        'app.Services',
        'app.Photos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('BookingsServices') ? [] : ['className' => BookingsServicesTable::class];
        $this->BookingsServices = $this->getTableLocator()->get('BookingsServices', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->BookingsServices);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\BookingsServicesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\BookingsServicesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
