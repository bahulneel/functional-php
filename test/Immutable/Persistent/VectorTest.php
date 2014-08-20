<?php
namespace BahulNeel\Immutable\Persistent;

use PHPUnit_Framework_TestCase;

class VectorTest extends PHPUnit_Framework_TestCase
{
    public function testConstruction()
    {
        $vector = new Vector(["foo"]);
        $vector1 = $vector->append("bar");

        $this->assertTrue(isset($vector[0]));
        $this->assertFalse(isset($vector[1]));
        $this->assertEquals(1, count($vector));
        $this->assertEquals("foo", $vector[0]);
        $this->assertEquals(2, count($vector1));
        $this->assertEquals("bar", $vector1[1]);
    }
    
    public function testAssocExisting()
    {
        $vector = new Vector(["foo"]);
        $vector1 = $vector->assoc(0, "bar");
        
        $this->assertEquals(1, count($vector));
        $this->assertEquals("foo", $vector[0]);
        $this->assertEquals(1, count($vector1));
        $this->assertEquals("bar", $vector1[0]);
    }
    
    public function testAssocAppend()
    {
        $vector = new Vector(["foo"]);
        $vector1 = $vector->assoc(1, "bar");

        $this->assertEquals(1, count($vector));
        $this->assertEquals("foo", $vector[0]);
        $this->assertEquals(2, count($vector1));
        $this->assertEquals("bar", $vector1[1]);
    }
    
    /**
     * @expectedException \OutOfBoundsException
     */
    public function testAssocOOB()
    {
        $vector = new Vector(["foo"]);
        $vector1 = $vector->assoc(2, "bar");
    }
    
    public function testPeek()
    {
        $vector = new Vector(["foo", "bar"]);
        $this->assertEquals("bar", $vector->peek());
    }
    
    public function testPop()
    {
        $vector = new Vector(["foo", "bar"]);
        $vector1 = $vector->pop();
        
        $this->assertEquals(2, count($vector));
        $this->assertEquals("foo", $vector[0]);
        $this->assertEquals("bar", $vector[1]);
        $this->assertEquals(1, count($vector1));
        $this->assertEquals("foo", $vector1[0]);
    }
    
    /**
     * @expectedException \LogicException
     */
    public function testSet()
    {
        $vector = new Vector(["foo", "bar"]);
        $vector[1] = 0;
    }
    
    /**
     * @expectedException \LogicException
     */
    public function testUnset()
    {
        $vector = new Vector(["foo", "bar"]);
        unset($vector[1]);
    }
}
