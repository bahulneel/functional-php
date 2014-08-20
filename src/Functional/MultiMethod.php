<?php
namespace BahulNeel\Functional;

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
        if (!isset($this->bindings[$key])) {
            throw new \InvalidArgumentException('No binding for key ' . $key);
        }
        return call_user_func_array(array($this, $this->bindings[$key]), $args);
    }
}
