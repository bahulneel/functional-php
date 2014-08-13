<?php
namespace Immutable\Trie;

class Leaf
{
    private $index;
    private $value;

    public function __construct($index, $value)
    {
        $this->index = $index;
        $this->value = $value;
    }
    
    public function getIndex()
    {
        return $this->index;
    }
    
    public function getValue()
    {
        return $this->value;
    }
}
