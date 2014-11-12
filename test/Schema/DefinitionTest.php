<?php
namespace Phonon\Schema;

use PHPUnit_Framework_TestCase;

class DefinitionTesat extends PHPUnit_Framework_TestCase
{
    public function getBasicTypeExamples()
    {
        return [
            ["integer", 1],
            ["float", 1.1],
            ["boolean", true],
            ["string", "hello"],
            ["null", null],
            ["number", 1],
            ["number", 1.1],
            ["number", "1"],
        ];
    }

    public function getBasicTypeBadExamples()
    {
        return [
            ["integer", 1.1],
            ["float", 1],
            ["boolean", null],
            ["string", true],
            ["null", "hello"],
            ["number", false],
            ["number", "world"],
        ];
    }

    /**
     * @dataProvider getBasicTypeExamples
     */
    public function testBasicTypeValidation($type, $value)
    {
        $validate = Validator::create();
        $this->assertEquals($value, $validate($type, $value));
    }

    /**
     * @expectedException \RuntimeException
     * @dataProvider getBasicTypeBadExamples
     */
    public function testBadTypeValidation($type, $value)
    {
        $validate = Validator::create();
        $validate($type, $value);
    }

    /**
     * @expectedException \RuntimeException
     * @dataProvider getBasicTypeExamples
     */
    public function testArrayValidation($type, $value)
    {
        $validate = Validator::create();
        $arrayType = [$type];
        $arrayValue = array_fill(0, 10, $value);
        $validate($arrayType, $arrayValue);
    }
}
