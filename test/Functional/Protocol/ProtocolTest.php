<?php
namespace Functional\Protocol;

use ArrayObject;
use PHPUnit_Framework_TestCase;

class ProtocolTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        Sequence::extend("array", "Functional\Protocol\ArraySequence");
        Sequence::extend("NULL", "Functional\Protocol\NullSequence");
        Sequence::extend("ArrayObject", "Functional\Protocol\ArrayObjectSequence");
    }
    
    public function testArray()
    {
        $array = [1, 2, 3, 4];
        $this->assertEquals(1, Sequence::first($array));
        $this->assertEquals([2, 3, 4], Sequence::rest($array));
    }
    
    public function testNull()
    {
        $this->assertEquals("nil", Sequence::first(null));
        $this->assertEquals("also nil", Sequence::rest(null));
    }
    
    public function testArrayObject()
    {
        $array = new ArrayObject([1, 2, 3, 4]);
        $this->assertEquals(1, Sequence::first($array));
        $this->assertEquals([2, 3, 4], Sequence::rest($array)->getArrayCopy());
    }
}

class ArraySequence implements SequenceInterface
{
    public static function first($coll)
    {
        if (!count($coll)) {
            return null;
        }

        return $coll[0];
    }

    public static function rest($coll)
    {
        return array_slice($coll, 1);
    }

}

class ArrayObjectSequence extends ArraySequence
{
    public static function rest($coll)
    {
        return new ArrayObject(Sequence::rest($coll->getArrayCopy()));
    }
}

class NullSequence implements SequenceInterface
{
    public static function first($coll)
    {
        return "nil";
    }

    public static function rest($coll)
    {
        return "also nil";
    }

}
