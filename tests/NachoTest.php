<?php
// require __DIR__ . "/../src/Nacho.php";

use Falces\Nacho;

class NachoTest extends PHPUnit_Framework_TestCase
{
    public function testNachHasCheese()
    {
        $nacho = new Nacho();
        $this->assertTrue($nacho->hasCheese());
        // $this->assertFalse($nacho->hasCheese(false));
    }
}
