<?php
namespace Functional\Protocol;

use Functional\HandlerMap;

class Protocol
{
    /**
     * @var HandlerMap
     */
    private static $implementations;

    private static function init()
    {
        if (!self::$implementations) {
            self::$implementations = new HandlerMap();
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
        self::$implementations->addHandler($type, $handler);
    }
}
