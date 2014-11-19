<?php
namespace Phonon\Transducers\Into;

use Phonon\Transducers\IntoInterface;
use Phonon\Transducers\Transducers;

class FileInto implements IntoInterface
{
    public static function into($empty, $xf, $coll)
    {
        $f = function($fileResource, $x) {
            fputs($fileResource, $x);
            return $fileResource;
        };
        return Transducers::transduce($xf, $f, $empty, $coll);
    }
}
