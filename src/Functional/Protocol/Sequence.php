<?php
namespace Functional\Protocol;

class Sequence implements SequenceInterface 
{
    use Protocol;

    public static function first($coll)
    {
        return self::invoke(__FUNCTION__, func_get_args());
    }
    
    public static function rest($coll)
    {
        return self::invoke(__FUNCTION__, func_get_args());
    }
}
