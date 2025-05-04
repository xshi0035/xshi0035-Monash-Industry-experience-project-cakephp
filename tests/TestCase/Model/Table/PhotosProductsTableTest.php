<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PhotosProductsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PhotosProductsTable Test Case
 */
class PhotosProductsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PhotosProductsTable
     */
    protected $PhotosProducts;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.PhotosProducts',
        'app.Photos',
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
        $config = $this->getTableLocator()->exists('PhotosProducts') ? [] : ['className' => PhotosProductsTable::class];
        $this->PhotosProducts = $this->getTableLocator()->get('PhotosProducts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PhotosProducts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PhotosProductsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PhotosProductsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
