<?php
namespace Phonon\Immutable\Trie;

use PHPUnit_Framework_TestCase;

class TrieTest extends PHPUnit_Framework_TestCase
{

    public function getPaths()
    {
        $args = [];
        
        $args[] = [0, [0, 0, 0, 0, 0, 0, 0]];
        $expected  = [0, 0, 0, 0, 0, 0, 1];
        do {
            array_shift($expected);
            array_push($expected, 0);
            $index = 0;
            foreach ($expected as $offset) {
                $index = $index << 5;
                $index += $offset;
            }
            $args[] = [$index, $expected];
        } while ($expected[0] !== 1);

        return $args;
    }

    /**
     * @dataProvider getPaths
     */
    public function testPath($index, $expected)
    {
        $trie = new Trie;
        $actual = $trie->getPath($index);
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @dataProvider getPaths
     */
    public function testAssoc($index, $path)
    {
        $trie = (new Trie)->put($index, $path);
        $this->assertEquals($path, $trie->get($index));
    }
    
    public function testBasicImmutable()
    {
        $oldTrie = (new Trie)->put(0, 0);
        $newTrie = $oldTrie->put(0, 1);
        
        $this->assertSame(0, $oldTrie->get(0));
        $this->assertSame(1, $newTrie->get(0));
    }
    
    public function testImmutable()
    {
        $tries = [];
        $tries[0] = new Trie;
        
        for($i = 1; $i < 10; $i++) {
            $tries[$i] = $tries[$i-1]->put($i, $i);
            for($j = 1; $j<$i; $j++) {
                $this->assertSame($j, $tries[$i]->get($j), "Still has old data");
            }
        }
        
        for($i = 0; $i < 10; $i++) {
            for($j = 0; $j < 10; $j++) {
                if ($i === $j) {
                    continue;
                }
                $this->assertNotSame($tries[$i], $tries[$j], "Not the same instance");
            }
        }
    }
    
    public function testStructuralSharing()
    {
        $trie1 = (new Trie)->put(0, 0);
        $trie2 = $trie1->put(32, 32);
        
        $path0 = $trie1->getPath(0);
        $node10 = $trie1->getRoot()->get($path0);
        $node20 = $trie2->getRoot()->get($path0);
        $this->assertSame($node10, $node20);
    }
    
    public function testRemove()
    {
        $trie1 = (new Trie)->put(0, 0);
        $trie2 = (new Trie)->remove(0);
        $this->assertSame(0, $trie1->get(0));
        $this->assertNull($trie2->get(0));
    }
}
