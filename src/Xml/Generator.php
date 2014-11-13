<?php
namespace Phonon\Xml;

use \Phonon\Transducers\Transducers as t;

class Generator
{
    public static function generateElement($document, $xml)
    {
        $generator = new Generate\Element;
        return $generator($document, $xml);
    }

    public static function generateDocument($xml)
    {
        $document = new \DOMDocument;
        $element = self::generateElement($document, $xml);
        $document->appendChild($element);
        return $document;
    }

    public static function generateString($xml)
    {
        $document = self::generateDocument($xml);
        return $document->saveXML($document->firstChild);
    }
}
