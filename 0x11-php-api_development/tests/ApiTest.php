<?php
/**
 * tests/ApiTest.php
 *
 * PHPUnit test case for API endpoints.
 */

use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase {

    public function testSimpleApi() {
        $output = shell_exec('curl -s http://localhost:8000/0-simple_api.php');
        $this->assertEquals("Welcome to the API!", trim($output));
    }

    public function testJsonApi() {
        $output = json_decode(shell_exec('curl -s http://localhost:8000/1-json_api.php'));
        $this->assertObjectHasAttribute("message", $output);
        $this->assertEquals("Success", $output->message);
    }
}
?>
/**
 *
 * To run: phpunit tests/ApiTest.php
 *
 */
