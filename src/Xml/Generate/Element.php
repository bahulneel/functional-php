<?php
namespace Phonon\Xml\Generate;

class Element extends \Phonon\Poly\MultiMethod
{
    public function getKey($args)
    {
        if (is_string($args[1])) {
            return "text";
        }

        if (is_array($args[1])) {
            return $this->getElementType($args[1]);
        }
    }

    public function getElementType($element)
    {
        if (count($element) == 1) {
            return "tag";
        }
        if (count($element) == 2) {
            if (\Phonon\Transducers\Transducers::isAssoc($element[1])) {
                return "tag-attr";
            } else {
                return "tag-body";
            }
        }
        if (count($element) == 3) {
            return "tag-attr-body";
        }
    }

    /**
     * @Key tag
     */
    public function tag(\DOMDocument $document, $args)
    {
        list($tagName) = $args;
        return $document->createElement($tagName);
    }

    /**
     * @Key tag-attr
     */
    public function tagAttr(\DOMDocument $document, $args)
    {
        list($tagName, $attrs) = $args;
        $element = $document->createElement($tagName);
        foreach ($attrs as $name => $value) {
            $element->setAttribute($name, $value);
        }
        return $element;
    }

    /**
     * @Key tag-body
     */
    public function tagBody(\DOMDocument $document, $args)
    {
        list($tagName, $body) = $args;
        return $this->tagAttrBody($document, [$tagName, [], $body]);
    }

    /**
     * @Key tag-attr-body
     */
    public function tagAttrBody(\DOMDocument $document, $args)
    {
        list($tagName, $attrs, $body) = $args;
        $element = $this->tagAttr($document, [$tagName, $attrs]);

        foreach ($body as $item) {
            $element->appendChild($this($document, $item));
        }

        return $element;
    }

    /**
     * @Key text
     */
    public function text(\DOMDocument $document, $text)
    {
        return $document->createTextNode($text);
    }
}
