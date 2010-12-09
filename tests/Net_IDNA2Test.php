<?php
require_once 'Net/IDNA2.php';
require_once 'PHPUnit2/Framework/TestCase.php';

class Net_IDNA2Test extends PHPUnit2_Framework_TestCase
{
    /**
     * Initialise tests
     *
     * @return void
     */
    public function setUp()
    {
        $this->idn = new Net_IDNA2();
    }

    /**
     * Test if a complete URL consisting also of port-number etc. will be decoded just fine
     *
     * @return void
     */
    public function testShouldDecodePortNumbersFragmentsAndUrisCorrectly()
    {
        // not sure where this testcase came from, but it's wrong
        // $result = $this->idn->decode('http://www.xn--ml-6kctd8d6a.org:8080/test.php?arg1=1&arg2=2#fragment');
        // $this->assertSame("http://www.╨╡╤à╨░m╤Çl╨╡.org:8080/test.php?arg=1#fragment", $result);
        $result = $this->idn->decode('http://xn--tst-qla.example.com:8080/test.php?arg1=1&arg2=2#fragment');
        $this->assertSame("http://täst.example.com:8080/test.php?arg1=1&arg2=2#fragment", $result);
    }

    /**
     * Test encoding of German letter Eszett according to the original standard (IDNA2003)
     *
     * @return void
     */
    public function testEncodingForGermanEszettUsingIDNA2003()
    {
        // make sure to use 2003-encoding
        $this->idn->setParams('version', '2003');
        $result = $this->idn->encode('http://www.straße.example.com/');

        $this->assertSame("http://www.strasse.example.com/", $result);
    }

    /**
     * Test encoding of German letter Eszett according to the "new" standard (IDNA2005/IDNAbis)
     *
     * @return void
     */
    public function testEncodingForGermanEszettUsingIDNA2008()
    {
        // make sure to use 2008-encoding
        $this->idn->setParams('version', '2008');
        $result = $this->idn->encode('http://www.straße.example.com/');
        // switch back for other testcases
        $this->idn->setParams('version', '2003');

        $this->assertSame("http://www.xn--strae-oqa.example.com/", $result);
    }
}
