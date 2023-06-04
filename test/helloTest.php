<?php

require('vendor/autoload.php');

use App\Controller\HelloController;
use PHPUnit\Framework\TestCase;

class HelloTest extends TestCase
{
    public function testHello(): void
    {
        $hello = new HelloController();
        $result = $hello->hello();
        $this->assertEquals('Hello', $result);
    }
}