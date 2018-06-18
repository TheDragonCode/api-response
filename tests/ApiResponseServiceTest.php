<?php

namespace Helldar\ApiResponse\Tests;

use PHPUnit\Framework\TestCase;

class ApiResponseServiceTest extends TestCase
{
    public function testInit()
    {
        $this->assertJson(api_response('ok')->getContent());
        $this->assertJson(api_response('fail', 400)->getContent());

        $this->assertJsonStringEqualsJsonString(api_response('ok')->getContent(), json_encode('ok'));
        $this->assertEquals(api_response('ok')->getContent(), json_encode('ok'));

        $this->assertEquals(api_response('ok', 401)->getStatusCode(), 401);
        $this->assertEquals(api_response('ok')->getStatusCode(), 200);

        $this->assertJsonStringEqualsJsonString(api_response('fail', 400)->getContent(), json_encode(['error' => ['code' => 400, 'msg' => 'fail']]));

        $this->assertJsonStringNotEqualsJsonString(api_response('fail', 400)->getContent(), json_encode('ok'));
    }
}
