<?php
namespace Phonon\Transducers;

interface IntoInterface
{
    public static function into($empty, $xf, $coll);
}
