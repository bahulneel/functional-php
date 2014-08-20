<?php
namespace Functional;

class MultiMethodTest extends \PHPUnit_Framework_TestCase
{

    public function testCallable()
    {
        $myMulti = new MyMulti;
        $this->assertTrue(is_callable($myMulti));
    }

    public function testCallFoo()
    {
        $myMulti = new MyMulti;
        $this->assertTrue($myMulti('foo'));
    }
    
    
    public function testCallBar()
    {
        $myMulti = new MyMulti;
        $this->assertTrue($myMulti('bar'));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCallMissing()
    {
        $myMulti = new MyMulti;
        $myMulti('baz');
    }
    
    /**
     * @expectedException \RuntimeException
     */
    public function testBadMulti()
    {
        $myMulti = new MyBadMulti;
    }
}

class MyMulti extends MultiMethod
{

    public function getKey($args)
    {
        return strval($args[0]);
    }

    /**
     * @Key foo
     */
    public function foo($foo)
    {
        return ($foo === 'foo');
    }
    
    /**
     * @Key bar
     */
    public function bar($foo)
    {
        return ($foo === 'bar');
    }
}

class MyBadMulti extends MultiMethod
{

    public function getKey($args)
    {
        return strval($args[0]);
    }

    /**
     * @Key foo
     */
    public function foo($foo)
    {
        return ($foo === 'foo');
    }
    
    /**
     * @Key foo
     */
    public function bar($foo)
    {
        return ($foo === 'bar');
    }
}