<?php

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Net_IDNA2_AllTests::main');
}

require_once 'PHPUnit/TextUI/TestRunner.php';

require_once 'Net_IDNA2Test.php';

class Net_IDNA2_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('PEAR - Net_IDNA2');

        $suite->addTestSuite('Net_IDNA2Test');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'Net_IDNA2_AllTests::main') {
    Net_IDNA2_AllTests::main();
}