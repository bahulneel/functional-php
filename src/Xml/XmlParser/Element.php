<?php
namespace Phonon\Xml\XmlParser;

use \Phonon\Transducers\Transducers as t;

class Element implements \Phonon\Xml\XmlParserInterface
{
    public static function parse($xml)
    {
        /* @var $xml \DOMElement */
        $element = [$xml->tagName];
        if ($xml->hasAttributes()) {
            $xf = t::comp(
                t::map(t::value()),
                t::map(function (\DOMAttr $attr) {
                    return [$attr->name, $attr->value];
                })
            );
            $element[] = t::intoAssoc([], $xf, $xml->attributes);
        }
        if ($xml->hasChildNodes()) {
            $xf = t::comp(
                t::map(t::value()),
                t::map(['\Phonon\Xml\XmlParser', 'parse'])
            );
            $element[] = t::into([], $xf, $xml->childNodes);
        }
        return $element;
    }
}
