<?php
namespace Functional\Protocol;

use Functional\HandlerMap;

trait Protocol
{
    /**
     * @var HandlerMap
     */
    private static $implementations;

    private static $interfaces;

    private static function init()
    {
        if (!self::$implementations) {
            self::$implementations = new HandlerMap();
        }
        if (!self::$interfaces) {
            $class = new \ReflectionClass(__CLASS__);
            $interfaces = $class->getInterfaceNames();
            self::$interfaces = $interfaces;
        }
    }

    public static function invoke($method, $args)
    {
        self::init();
        $first = $args[0];
        $handler = self::$implementations->getHandler($first);
        return call_user_func_array(array($handler, $method), $args);
    }
    
    public static function extend($type, $handler)
    {
        self::init();
        $class = new \ReflectionClass($handler);
        foreach (self::$interfaces as $interface) {
            if (!$class->implementsInterface($interface)) {
                throw new \InvalidArgumentException("Implementation must implement " . $interface);
            }
        }
        self::$implementations->addHandler($type, $handler);
    }
}
