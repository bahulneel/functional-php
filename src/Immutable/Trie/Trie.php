<?php
namespace BahulNeel\Immutable\Trie;

class Trie
{

    /**
     * @var Node
     */
    private $root;

    public function __construct()
    {
        $this->root = new Node(32);
    }

    public function getPath($index)
    {
        $path = [];
        for ($level = 0; $level < 7; ++$level) {
            $shifts = $level * 5;
            $offset = ($index >> $shifts) & 0x1f;
            array_unshift($path, $offset);
        }
        return $path;
    }

    public function put($index, $value)
    {
        $path = $this->getPath($index);
        $leaf = new Leaf($index, $value);
        $trie = new Trie;
        $trie->root = $this->root->put($leaf, $path);
        return $trie;
    }

    public function get($index, $default = null)
    {
        $path = $this->getPath($index);
        $value = $this->root->get($path, $default);
        if ($value instanceof Leaf) {
            return $value->getValue();
        }
        return $default;
    }
    
    public function remove($index)
    {
        $path = $this->getPath($index);
        $trie = new Trie;
        $trie->root = $this->root->put(null, $path);
        return $trie;
    }

    public function getRoot()
    {
        return $this->root;
    }
}
