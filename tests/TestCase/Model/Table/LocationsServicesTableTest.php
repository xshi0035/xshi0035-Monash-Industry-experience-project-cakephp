<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocationsServicesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocationsServicesTable Test Case
 */
class LocationsServicesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LocationsServicesTable
     */
    protected $LocationsServices;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.LocationsServices',
        'app.Locations',
        'app.Services',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('LocationsServices') ? [] : ['className' => LocationsServicesTable::class];
        $this->LocationsServices = $this->getTableLocator()->get('LocationsServices', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LocationsServices);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LocationsServicesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LocationsServicesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
