<?php
namespace Phonon\Transducers\Into;

use Phonon\Transducers\IntoInterface;
use Phonon\Transducers\Transducers;

class StringInto implements IntoInterface
{
    public static function into($empty, $xf, $coll)
    {
        $f = function($str, $x) {
            $str .= $x;
            return $str;
        };
        return Transducers::transduce($xf, $f, $empty, $coll);
    }
}
