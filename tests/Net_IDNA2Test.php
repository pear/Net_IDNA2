<?php
require_once 'Net/IDNA2.php';
require_once 'PHPUnit/Framework.php';

class Net_IDNA2Test extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $this->idn = new Net_IDNA2();
    }

    public function testShouldDecodePortNumbersFragmentsAndUrisCorrectly() {
        $result = $this->idn->decode('http://www.xn--ml-6kctd8d6a.org:8080/test.php?arg=1#fragment');

        $this->assertSame("http://www.\xD0\xB5\xD1\x85\xD0\xB0m\xD1\x80l\xD0\xB5.org:8080/test.php?arg=1#fragment", $result);
    }

    /**
     * Encoding test data
     */
    public function encode() {
        $data = array();

        $name = "Map to nothing";
        $input = "foo\xC2\xAD\xCD\x8F\xE1\xA0\x86\xE1\xA0\x8B"
                                        . "bar\xE2\x80\x8B\xE2\x81\xA0"
                                        . "baz\xEF\xB8\x80\xEF\xB8\x88\xEF\xB8\x8F\xEF\xBB\xBF";
        $output = "foobarbaz";

        $data[$name] = array($input, $output);


        $name = "Case folding ASCII U+0043 U+0041 U+0046 U+0045";
        $input = "CAFE";
        $output = "cafe";

        $data[$name] = array($input, $output);

        $name = "Case folding 8bit U+00DF (german sharp s)";
        $input = "\xC3\x9F";
        $output = "ss";
        $data[$name] = array($input, $output);

        $name = "Case folding U+0130 (turkish capital I with dot)";
        $input = "\xC4\xB0";
        $output = "i\xCC\x87";
        $data[$name] = array($input, $output);

/* // infinite loop!!!!!!??
        $name = "Case folding multibyte U+0143 U+037A";
        $input = "\xC5\x83\xCD\xBA";
        $output = "\xC5\x84 \xCE\xB9";
        $data[$name] = array($input, $output);
*/
        $name = "Case folding U+2121 U+33C6 U+1D7BB";
        $input = "\xE2\x84\xA1\xE3\x8F\x86\xF0\x9D\x9E\xBB";
        $output = "telc\xE2\x88\x95kg\xCF\x83";
        $data[$name] = array($input, $output);

        $name = "Normalization of U+006a U+030c U+00A0 U+00AA";
        $input = "\x6A\xCC\x8C\xC2\xA0\xC2\xAA";
        $output = "\xC7\xB0 a";
        $data[$name] = array($input, $output);

        $name = "Case folding U+1FB7 and normalization";
        $input = "\xE1\xBE\xB7";
        $output = "\xE1\xBE\xB6\xCE\xB9";
        $data[$name] = array($input, $output);

        $name = "Self-reverting case folding U+01F0 and normalization";
        $input = "\xC7\xF0";
        $output = "\xC7\xB0";
        $data[$name] = array($input, $output);

        $name = "Self-reverting case folding U+0390 and normalization";
        $input = "\xCE\x90";
        $output = "\xCE\x90";
        $data[$name] = array($input, $output);

        $name = "Self-reverting case folding U+03B0 and normalization";
        $input = "\xCE\xB0";
        $output = "\xCE\xB0";
        $data[$name] = array($input, $output);

        $name = "Self-reverting case folding U+1E96 and normalization";
        $input = "\xE1\xBA\x96";
        $output = "\xE1\xBA\x96";
        $data[$name] = array($input, $output);

        $name = "Self-reverting case folding U+1F56 and normalization";
        $input = "\xE1\xBD\x96";
        $output = "\xE1\xBD\x96";
        $data[$name] = array($input, $output);

        $name = "ASCII space character U+0020";
        $input = "\x20";
        $output = "\x20";
        $data[$name] = array($input, $output);

        $name = "Non-ASCII 8bit space character U+00A0";
        $input = "\xC2\xA0";
        $output = "\x20";
        $data[$name] = array($input, $output);

        $name = "Non-ASCII multibyte space character U+1680";
        $input = "\xE1\x9A\x80";
        $output = "";        // STRINGPREP_CONTAINS_PROHIBITED
        $data[$name] = array($input, $output);

        $name = "Non-ASCII multibyte space character U+2000";
        $input = "\xE2\x80\x80";
        $output = "\x20";
        $data[$name] = array($input, $output);

        $name = "Zero Width Space U+200b";
        $input = "\xE2\x80\x8b";
        $output = "";
        $data[$name] = array($input, $output);

        $name = "Non-ASCII multibyte space character U+3000";
        $input = "\xE3\x80\x80";
        $output = "\x20";
        $data[$name] = array($input, $output);

        $name = "ASCII control characters U+0010 U+007F";
        $input = "\x10\x7F";
        $output = "\x10\x7F";
        $data[$name] = array($input, $output);

        $name = "Non-ASCII 8bit control character U+0085";
        $input = "\xC2\x85";
        $output = "";// STRINGPREP_CONTAINS_PROHIBITED
        $data[$name] = array($input, $output);

        $name = "Non-ASCII multibyte control character U+180E";
        $input = "\xE1\xA0\x8E";
        $output = "";// STRINGPREP_CONTAINS_PROHIBITED
        $data[$name] = array($input, $output);

        $name = "Zero Width No-Break Space U+FEFF";
        $input = "\xEF\xBB\xBF";
        $output = "";
        $data[$name] = array($input, $output);

        $name ="Non-ASCII control character U+1D175";
        $input = "\xF0\x9D\x85\xB5";
        $output = "";// STRINGPREP_CONTAINS_PROHIBITED
        $data[$name] = array($input, $output);

        $name = "Plane 0 private use character U+F123";
        $input = "\xEF\x84\xA3";
        $output = "";// STRINGPREP_CONTAINS_PROHIBITED
        $data[$name] = array($input, $output);

        $name = "Plane 15 private use character U+F1234";
        $input = "\xF3\xB1\x88\xB4";
        $output = "";// STRINGPREP_CONTAINS_PROHIBITED
        $data[$name] = array($input, $output);

        $name = "Plane 16 private use character U+10F234";
        $input = "\xF4\x8F\x88\xB4";
        $output = "";// STRINGPREP_CONTAINS_PROHIBITED
        $data[$name] = array($input, $output);

        $name = "Non-character code point U+8FFFE";
        $input = "\xF2\x8F\xBF\xBE";
        $output = ""; // STRINGPREP_CONTAINS_PROHIBITED
        $data[$name] = array($input, $output);

        $name = "Non-character code point U+10FFFF";
        $input = "\xF4\x8F\xBF\xBF";
        $output = ""; // STRINGPREP_CONTAINS_PROHIBITED
        $data[$name] = array($input, $output);

        $name = "Surrogate code U+DF42";
        $input = "\xED\xBD\x82";
        $output = ""; // STRINGPREP_CONTAINS_PROHIBITED
        $data[$name] = array($input, $output);

        $name = "Non-plain text character U+FFFD";
        $input = "\xEF\xBF\xBD";
        $output = ""; // STRINGPREP_CONTAINS_PROHIBITED
        $data[$name] = array($input, $output);

        $name = "Ideographic description character U+2FF5";
        $input = "\xE2\xBF\xB5";
        $output = ""; // STRINGPREP_CONTAINS_PROHIBITED
        $data[$name] = array($input, $output);

        $name = "Display property character U+0341";
        $input = "\xCD\x81";
        $output = "\xCC\x81";
        $data[$name] = array($input, $output);

        $name = "Left-to-right mark U+200E";
        $input = "\xE2\x80\x8E";
        $output = "\xCC\x81";// STRINGPREP_CONTAINS_PROHIBITED
        $data[$name] = array($input, $output);

        $name = "Deprecated U+202A";
        $input = "\xE2\x80\xAA";
        $output = "\xCC\x81";// STRINGPREP_CONTAINS_PROHIBITED
        $data[$name] = array($input, $output);

        $name = "Language tagging character U+E0001";
        $input = "\xF3\xA0\x80\x81";
        $output = "\xCC\x81";// STRINGPREP_CONTAINS_PROHIBITED
        $data[$name] = array($input, $output);

        $name = "Language tagging character U+E0042";
        $input = "\xF3\xA0\x81\x82";
        $output = ""; // STRINGPREP_CONTAINS_PROHIBITED
        $data[$name] = array($input, $output);

        $name = "Bidi: RandALCat character U+05BE and LCat characters";
        $input = "foo\xD6\xBEbar";
        $output = ""; //STRINGPREP_BIDI_BOTH_L_AND_RAL
        $data[$name] = array($input, $output);

        $name = "Bidi: RandALCat character U+FD50 and LCat characters";
        $input = "foo\xEF\xB5\x90bar";
        $output = "";//STRINGPREP_BIDI_BOTH_L_AND_RAL
        $data[$name] = array($input, $output);

        $name = "Bidi: RandALCat character U+FB38 and LCat characters";
        $input = "foo\xEF\xB9\xB6bar";
        $output = "foo \xd9\x8ebar";
        $data[$name] = array($input, $output);

        $name = "Bidi: RandALCat without trailing RandALCat U+0627 U+0031";
        $input = "\xD8\xA7\x31";
        $output = ""; //STRINGPREP_BIDI_LEADTRAIL_NOT_RAL
        $data[$name] = array($input, $output);

        $name = "Bidi: RandALCat character U+0627 U+0031 U+0628";
        $input = "\xD8\xA7\x31\xD8\xA8";
        $output = "\xD8\xA7\x31\xD8\xA8";
        $data[$name] = array($input, $output);

        $name = "Unassigned code point U+E0002";
        $input = "\xF3\xA0\x80\x82";
        $output = ""; //STRINGPREP_CONTAINS_UNASSIGNED
        $data[$name] = array($input, $output);

        $name = "Larger test (shrinking)";
        $input = "X\xC2\xAD\xC3\x9F\xC4\xB0\xE2\x84\xA1\x6a\xcc\x8c\xc2\xa0\xc2"
            ."\xaa\xce\xb0\xe2\x80\x80";
        $output = "xssi\xcc\x87tel\xc7\xb0 a\xce\xb0 ";
        $data[$name] = array($input, $output);

        $name = "Larger test (expanding)";
        $input = "X\xC3\x9F\xe3\x8c\x96\xC4\xB0\xE2\x84\xA1\xE2\x92\x9F\xE3\x8c\x80";
        $output = "xss\xe3\x82\xad\xe3\x83\xad\xe3\x83\xa1\xe3\x83\xbc\xe3\x83\x88"
            ."\xe3\x83\xabi\xcc\x87tel\x28d\x29\xe3\x82\xa2\xe3\x83\x91"
            ."\xe3\x83\xbc\xe3\x83\x88";
        $data[$name] = array($input, $output);

        return $data;
    }

    /**
     * @dataProvider encode()
     */
    public function testShouldEncodeProperly($in, $out) {
        $this->assertSame($out, $this->idn->encode($in));
    }
}
