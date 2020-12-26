<?php

namespace Tests\Fixtures\Contracts;

interface Parserable
{
    public function testResponse();

    public function testJson();

    public function testStructure();

    public function testStatusCode();
}
