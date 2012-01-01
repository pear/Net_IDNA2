<?php

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Net_IDNA2_AllTests::main');
}

if ($fp = @fopen('PHPUnit/Autoload.php', 'r', true)) {
    require_once 'PHPUnit/Autoload.php';
} elseif ($fp = @fopen('PHPUnit/Framework.php', 'r', true)) {
    require_once 'PHPUnit/Framework.php';
    require_once 'PHPUnit/TextUI/TestRunner.php';
} else {
    die("skip could not find PHPUnit\n");
}
fclose($fp);

class Net_IDNA2_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('PEAR - Net_IDNA2');

        $suite->addTestFile(dirname(__FILE__) . '/Net_IDNA2Test.php');
        $suite->addTestFile(dirname(__FILE__) . '/draft-josefsson-idn-test-vectors.php');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'Net_IDNA2_AllTests::main') {
    Net_IDNA2_AllTests::main();
}
