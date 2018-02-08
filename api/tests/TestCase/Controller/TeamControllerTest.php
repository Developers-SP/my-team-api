<?php
namespace App\Test\TestCase\Controller;

use App\Controller\TeamController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\TeamController Test Case
 */
class TeamControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.team'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testInsertOK()
    {
        $data = [
            'id' => '76561198121209165',
            'name' => 'Vk'
        ];

        $this->post('/team/insert', $data);

        $this->assertResponseCode(200);
        $this->assertContentType("application/json");
        $this->assertResponseContains("id");
        $this->assertResponseContains("OK");
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
