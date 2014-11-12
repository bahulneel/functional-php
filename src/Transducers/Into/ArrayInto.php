<?php
namespace Phonon\Transducers\Into;

use Phonon\Transducers\IntoInterface;
use Phonon\Transducers\Transducers;

class ArrayInto implements IntoInterface
{
    public static function into($empty, $xf, $coll)
    {
        $f = function($arr, $x) {
            $arr[] = $x;
            return $arr;
        };
        return Transducers::transduce($xf, $f, $empty, $coll);
    }
}
