<?php
namespace Phonon\Transducers;

interface ReduceInterface
{
    public static function reduce($coll, TransformerInterface $xf, $init);
}
