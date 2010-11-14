<?php
require_once 'Net/IDNA2.php';
require_once 'PHPUnit2/Framework/TestCase.php';

class Net_IDNA2Test extends PHPUnit2_Framework_TestCase {

    public function setUp() {
        $this->idn = new Net_IDNA2();
    }

    public function testShouldDecodePortNumbersFragmentsAndUrisCorrectly() {
        $result = $this->idn->decode('http://www.xn--ml-6kctd8d6a.org:8080/test.php?arg=1#fragment');

// not sure where this testcase came from, but it's wrong
//        $this->assertSame("http://www.╨╡╤à╨░m╤Çl╨╡.org:8080/test.php?arg=1#fragment", $result);
        $this->assertSame("http://www.example.org:8080/test.php?arg=1#fragment", $result);
    }

    public function testEncodingForGermanEszettUsingIDNA2003() {
        // make sure to use 2003-encoding
        $this->idn->setParams('version', '2003');
        $result = $this->idn->encode('http://www.straße.example.com/');

        $this->assertSame("http://www.strasse.example.com/", $result);
    }

    public function testEncodingForGermanEszettUsingIDNA2008() {
        // make sure to use 2008-encoding
        $this->idn->setParams('version', '2008');
        $result = $this->idn->encode('http://www.straße.example.com/');
        // switch back for other testcases
        $this->idn->setParams('version', '2003');

        $this->assertSame("http://www.xn--strae-oqa.example.com/", $result);
    }
}
