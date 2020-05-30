<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MoviesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MoviesTable Test Case
 */
class MoviesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MoviesTable
     */
    protected $Movies;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Movies',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Movies') ? [] : ['className' => MoviesTable::class];
        $this->Movies = TableRegistry::getTableLocator()->get('Movies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Movies);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
