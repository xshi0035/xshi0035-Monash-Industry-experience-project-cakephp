<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BookingsServicesPhotosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BookingsServicesPhotosTable Test Case
 */
class BookingsServicesPhotosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BookingsServicesPhotosTable
     */
    protected $BookingsServicesPhotos;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.BookingsServicesPhotos',
        'app.BookingsServices',
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
        $config = $this->getTableLocator()->exists('BookingsServicesPhotos') ? [] : ['className' => BookingsServicesPhotosTable::class];
        $this->BookingsServicesPhotos = $this->getTableLocator()->get('BookingsServicesPhotos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->BookingsServicesPhotos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\BookingsServicesPhotosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\BookingsServicesPhotosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
