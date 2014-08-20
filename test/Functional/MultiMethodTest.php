<?php
namespace BahulNeel\Functional;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use RuntimeException;

class MultiMethodTest extends PHPUnit_Framework_TestCase
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
     * @expectedException InvalidArgumentException
     */
    public function testCallMissing()
    {
        $myMulti = new MyMulti;
        $myMulti('baz');
    }
    
    /**
     * @expectedException RuntimeException
     */
    public function testBadMulti()
    {
        $myMulti = new MyBadMulti;
    }
    
    public function testCallStatic()
    {
        $this->assertTrue(MyMulti::call('foo'));
        $this->assertTrue(MyMulti::call('bar'));
    }
    
    public function testDefault()
    {
        $this->assertTrue(MyDefaultMulti::call('foo'));
        $this->assertFalse(MyDefaultMulti::call('bar'));
    }
    
    public function testExtension()
    {
        $this->assertTrue(MyExtendedMulti::call('foo'));
        $this->assertTrue(MyExtendedMulti::call('baz'));
    }
    
    public function testOverloading()
    {
        $this->assertTrue(MyMulti::call('bar'));
        $this->assertFalse(MyExtendedMulti::call('bar'));
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

class MyDefaultMulti extends MultiMethod
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
    
    public function _default($foo)
    {
        return false;
    }
}

class MyExtendedMulti extends MyMulti
{
    /**
     * @Key bar
     */
    public function bar($foo)
    {
        return ($foo !== 'bar');
    }

    /**
     * @Key baz
     */
    public function baz($foo)
    {
        return ($foo === 'baz');
    }
}
