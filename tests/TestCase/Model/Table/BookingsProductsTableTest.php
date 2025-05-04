<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BookingsProductsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BookingsProductsTable Test Case
 */
class BookingsProductsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BookingsProductsTable
     */
    protected $BookingsProducts;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.BookingsProducts',
        'app.Bookings',
        'app.Products',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('BookingsProducts') ? [] : ['className' => BookingsProductsTable::class];
        $this->BookingsProducts = $this->getTableLocator()->get('BookingsProducts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->BookingsProducts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\BookingsProductsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\BookingsProductsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
