<?php
namespace BahulNeel\Poly;

abstract class MultiMethod
{
    private $bindings;

    final public function __construct()
    {
        $this->bindings = $this->getInvocationBindings();
    }

    abstract public function getKey($args);

    public function getInvocationBindings()
    {
        $object = new \ReflectionObject($this);
        $methods = $object->getMethods();
        $bindings = [];

        foreach ($methods as $method) {
            /* @var $method ReflectionMethod */
            $annotations = new \zpt\anno\Annotations($method);
            if (!isset($annotations['Key'])) {
                continue;
            }
            $key = $annotations['Key'];
            if (isset($bindings[$key])) {
                throw new \RuntimeException("Key {$key} alread bound to method {$bindings[$key]}");
            }
            $bindings[$key] = $method->getName();
        }
        return $bindings;
    }

    public function __invoke()
    {
        $args = func_get_args();
        $key = $this->getKey($args);
        
        if (isset($this->bindings[$key])) {
            return call_user_func_array(array($this, $this->bindings[$key]), $args);
        }
        
        if (method_exists($this, '_default')) {
            return call_user_func_array(array($this, '_default'), $args);
        }
        throw new \InvalidArgumentException('No binding for key ' . $key);
    }
    
    public static function call()
    {
        $args = func_get_args();
        $impl = new static;
        return call_user_func_array($impl, $args);
    }
}
