<?php
namespace Phonon\Xml;

use PHPUnit_Framework_TestCase;

class XmlTest extends PHPUnit_Framework_TestCase
{
    public function getForms()
    {
        return [
            ["<tag/>", ["tag"]],
            ["<tag a=\"b\"/>", ["tag", ["a" => "b"]]],
            ["<tag a=\"b\" c=\"d\"/>", ["tag", ["a" => "b", "c" => "d"]]],
            ["<tag>content</tag>", ["tag", ["content"]]],
            ["<tag a=\"b\">content</tag>", ["tag", ["a" => "b"], ["content"]]],
            ["<tag><tag2/></tag>", ["tag", [["tag2"]]]],
            ["<tag>content<tag2/></tag>", ["tag", ["content", ["tag2"]]]],
            ["<tag>content<tag2 key=\"value\"/>more content</tag>", ["tag", [
                "content",
                ["tag2", ["key" => "value"]],
                "more content"
            ]]],
        ];
    }

    /**
     * @dataProvider getForms
     */
    public function testParseString($string, $expected)
    {
        $actual = Parser::parseXml($string);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider getForms
     */
    public function testGenerateString($expected, $xml)
    {
        $actual = Generator::generateString($xml);
        $this->assertEquals($expected, $actual);
    }
}
