<?php
require_once 'Net/IDNA2.php';
require_once 'PHPUnit/Framework.php';

class Net_IDNA2Test extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $this->idn = new Net_IDNA2();
    }

    public function testShouldDecodePortNumbersFragmentsAndUrisCorrectly() {
        $result = $this->idn->decode('http://www.xn--ml-6kctd8d6a.org:8080/test.php?arg=1#fragment');

        $this->assertSame("http://www.╨╡╤à╨░m╤Çl╨╡.org:8080/test.php?arg=1#fragment", $result);
    }
}