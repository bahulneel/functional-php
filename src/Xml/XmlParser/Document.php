<?php
namespace Phonon\Xml\XmlParser;

use Phonon\Xml\XmlParser;
use Phonon\Xml\XmlParserInterface;

class Document implements XmlParserInterface
{
    public static function parse($xml)
    {
        return XmlParser::parse($xml->firstChild);
    }
}
