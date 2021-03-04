<?php

namespace Tests\Fixtures\Contracts;

interface Testable
{
    public function testInstance();

    public function testType();

    public function testStructureSuccess();

    public function testStructureErrors();

    public function testStatusCode();
}
