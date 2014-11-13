<?php
namespace Phonon\Xml\XmlParser;

use DOMDocument;
use Phonon\Xml\XmlParser;
use Phonon\Xml\XmlParserInterface;

class String implements XmlParserInterface
{
    public static function parse($xml)
    {
        $document = new DOMDocument;
        $document->loadXML($xml);
        return XmlParser::parse($document);
    }
}
