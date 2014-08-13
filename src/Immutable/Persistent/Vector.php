<?php
namespace Immutable\Persistent;

use ArrayAccess;
use Countable;
use Immutable\Trie\Trie;
use LogicException;

class Vector implements Countable, ArrayAccess
{
    /**
     * @var Trie
     */
    private $trie;

    private $count;

    public function __construct($array = [])
    {
        $trie = new Trie;
        $length = count($array);
        for ($i = 0; $i < $length; ++$i) {
            $trie = $trie->put($i, $array[$i]);
        }

        $this->trie = $trie;
        $this->count = $length;
    }

    /**
     * @param mixed $value
     * @return Vector
     */
    public function append($value)
    {
        $vector = new Vector;
        $vector->trie = $this->trie->put($this->count, $value);
        $vector->trie->count = $this->count++;
        return $vector;
    }

    public function assoc($index, $value)
    {
        if ($index === $this->count) {
            return $this->append($value);
        }
        
        if ($index > $this->count) {
            throw new \OutOfBoundsException('Cannot assoc pased the end of the vector');
        }
        $vector = new Vector;
        $vector->trie = $this->trie->put($index, $value);
        $vector->trie->count = $this->count;
        return $vector;
    }

    public function count()
    {
        return $this->count;
    }

    public function offsetExists($offset)
    {
        $value = $this->trie->get($offset, $this);
        if ($value === $this) {
            return false;
        }
        return true;
    }

    public function offsetGet($offset)
    {
        return $this->trie->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        throw new LogicException('Cannot set and immutable value');
    }

    public function offsetUnset($offset)
    {
        throw new LogicException('Cannot unset and immutable value');
    }

}
