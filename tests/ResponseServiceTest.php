<?php

namespace Helldar\ApiResponse\Tests;

use PHPUnit\Framework\TestCase;

class ResponseServiceTest extends TestCase
{
    public function testInit()
    {
        $this->assertJson(api_response('ok')->getContent());
        $this->assertJson(api_response('fail', 400)->getContent());

        $this->assertEquals(api_response('ok')->getContent(), json_encode('ok'));

        $this->assertEquals(api_response('ok', 401)->getStatusCode(), 401);
        $this->assertEquals(api_response('ok')->getStatusCode(), 200);
    }

    public function testStructure()
    {
        $this->assertJsonStringEqualsJsonString(api_response('ok')->getContent(), json_encode('ok'));
        $this->assertJsonStringEqualsJsonString(api_response('fail', 400)->getContent(), json_encode(['error' => ['code' => 400, 'msg' => 'fail']]));
        $this->assertJsonStringNotEqualsJsonString(api_response('fail', 400)->getContent(), json_encode('ok'));
    }

    public function testAdditionalContent()
    {
        $this->assertJson(api_response('ok', 200, [], ['foo' => 'bar'])->getContent());
        $this->assertJson(api_response('fail', 400, [], ['foo' => 'bar'])->getContent());

        $this->assertEquals(api_response('ok', 200, [], ['foo' => 'bar'])->getContent(), json_encode(['content' => 'ok', 'foo' => 'bar']));

        $this->assertEquals(api_response('ok', 400, [], ['foo' => 'bar'])->getContent(),
            json_encode([
                'error' => [
                    'code' => 400,
                    'msg'  => 'ok',
                ],
                'foo'   => 'bar',
            ])
        );
    }
}
