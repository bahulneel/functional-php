<?php
namespace BahulNeel\Immutable\Persistent;

use ArrayAccess;
use BahulNeel\Immutable\Trie\Trie;
use Countable;
use LogicException;
use OutOfBoundsException;

class Vector implements Countable, ArrayAccess
{
    /**
     * @var Trie
     */
    private $trie;

    private $count;

    public function __construct(array $array = [])
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
        $vector->count = $this->count + 1;
        return $vector;
    }

    /**
     * @param integer $index
     * @param moxed $value
     * @return Vector
     * @throws OutOfBoundsException
     */
    public function assoc($index, $value)
    {
        if ($index === $this->count) {
            return $this->append($value);
        }
        
        if ($index > $this->count) {
            throw new OutOfBoundsException('Cannot assoc pased the end of the vector');
        }
        $vector = new Vector;
        $vector->trie = $this->trie->put($index, $value);
        $vector->count = $this->count;
        return $vector;
    }

    /**
     * @return Mixed
     */
    public function peek()
    {
        return $this[$this->count - 1];
    }
    
    /**
     * @return Vector
     */
    public function pop()
    {
        $vector = new Vector;
        $vector->trie = $this->trie->remove($this->count - 1);
        $vector->count = $this->count - 1;
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
