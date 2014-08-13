<?php
namespace Immutable\Trie;

use SplFixedArray;

class Node extends SplFixedArray
{

    private $fresh = true;

    public function put($leaf, $path)
    {
        $position = array_pop($path);

        if ($this->fresh) {
            $newNode = $this;
            $this->fresh = false;
        } else {
            $newNode = clone($this);
        }

        if (empty($path)) {
            $newNode[$position] = $leaf;
            return $newNode;
        }

        if (!isset($newNode[$position])) {
            $newNode[$position] = new Node($this->getSize());
        }

        $nextNode = $newNode[$position];
        $newNode[$position] = $nextNode->put($leaf, $path);

        return $newNode;
    }

    public function get($path)
    {
        $position = array_pop($path);
        if (!isset($this[$position])) {
            return null;
        }

        if (empty($path)) {
            return $this[$position];
        }

        return $this[$position]->get($path);
    }

}
