<?php
namespace Functional\Protocol;

class Sequence extends Protocol implements SequenceInterface 
{
    public static function first($coll)
    {
        return self::invoke(__FUNCTION__, func_get_args());
    }
    
    public static function rest($coll)
    {
        return self::invoke(__FUNCTION__, func_get_args());
    }
}
