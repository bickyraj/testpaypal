<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ArticleUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ArticleUsersTable Test Case
 */
class ArticleUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ArticleUsersTable
     */
    public $ArticleUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.article_users',
        'app.users',
        'app.articles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ArticleUsers') ? [] : ['className' => 'App\Model\Table\ArticleUsersTable'];
        $this->ArticleUsers = TableRegistry::get('ArticleUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ArticleUsers);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
