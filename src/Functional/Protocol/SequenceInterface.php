<?php
namespace Functional\Protocol;

interface SequenceInterface
{
    public static function first($coll);
    
    public static function rest($coll);
}
