<?php
/**
 * @author  Andrey Helldar <helldar@ai-rus.com>
 * @version 2017-02-20
 */


namespace Helldar\ApiResponse;


class ApiResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ApiResponse
     */
    protected $object;

    public function testResponse()
    {
        $this->assertEquals(json_encode([
            'status_code' => 0,
            'status_text' => 'Other error',
            'response'    => null,
        ]), $this->object->response(0, null, 200));

        $this->assertEquals(json_encode([
            'status_code' => 1,
            'status_text' => 'Unknown method',
            'response'    => 'Unknown method',
        ]), $this->object->response(1, null, 200));
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new ApiResponse();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        // none
    }
}
