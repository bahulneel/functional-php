<?php
namespace Phonon\Transducers;

class Into implements IntoInterface
{

    use \Phonon\Poly\Protocol;

    public static function into($empty, $xf, $coll)
    {
        return self::invoke(__FUNCTION__, func_get_args());
    }
}
