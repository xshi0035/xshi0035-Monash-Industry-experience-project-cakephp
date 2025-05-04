<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UnavailabilitiesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UnavailabilitiesTable Test Case
 */
class UnavailabilitiesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UnavailabilitiesTable
     */
    protected $Unavailabilities;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Unavailabilities',
        'app.Locations',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Unavailabilities') ? [] : ['className' => UnavailabilitiesTable::class];
        $this->Unavailabilities = $this->getTableLocator()->get('Unavailabilities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Unavailabilities);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\UnavailabilitiesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\UnavailabilitiesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
