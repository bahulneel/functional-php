<?php
namespace Phonon\Xml;

class XmlParser implements XmlParserInterface
{
    use \Phonon\Poly\Protocol;

    public static function parse($xml)
    {
        return self::invoke(__FUNCTION__, func_get_args());
    }
}
