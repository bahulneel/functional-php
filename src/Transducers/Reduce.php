<?php
namespace Phonon\Transducers;

class Reduce implements ReduceInterface
{

    use \Phonon\Poly\Protocol;

    public static function reduce($coll, TransformerInterface $xf, $init)
    {
        return self::invoke(__FUNCTION__, func_get_args());
    }
}
