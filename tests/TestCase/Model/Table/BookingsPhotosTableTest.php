<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BookingsPhotosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BookingsPhotosTable Test Case
 */
class BookingsPhotosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BookingsPhotosTable
     */
    protected $BookingsPhotos;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.BookingsPhotos',
        'app.Bookings',
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
        $config = $this->getTableLocator()->exists('BookingsPhotos') ? [] : ['className' => BookingsPhotosTable::class];
        $this->BookingsPhotos = $this->getTableLocator()->get('BookingsPhotos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->BookingsPhotos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\BookingsPhotosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\BookingsPhotosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
