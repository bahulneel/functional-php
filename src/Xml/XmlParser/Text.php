<?php
namespace Phonon\Xml\XmlParser;

class Text implements \Phonon\Xml\XmlParserInterface
{
    public static function parse($xml)
    {
        /* @var $xml \DOMText */
        return $xml->wholeText;
    }
}
