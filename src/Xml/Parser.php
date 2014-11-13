<?php
namespace Phonon\Xml;

XmlParser::extend(gettype(""), "Phonon\Xml\XmlParser\String");
XmlParser::extend("DOMDocument", "Phonon\Xml\XmlParser\Document");
XmlParser::extend("DOMElement", "Phonon\Xml\XmlParser\Element");
XmlParser::extend("DOMText", "Phonon\Xml\XmlParser\Text");

class Parser
{
    public static function parseXml($xml)
    {
        return XmlParser::parse($xml);
    }
}
