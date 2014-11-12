<?php
namespace Phonon\Transducers\Reduce;

use Phonon\Transducers\ReduceInterface;
use Phonon\Transducers\Transducers;
use Phonon\Transducers\TransformerInterface;

class StringReduce implements ReduceInterface
{
    public static function reduce($coll, TransformerInterface $xf, $init)
    {
        $result = $init;
        $length = strlen($coll);
        for ($i = 0; $i < $length; $i += 1) {
            $result = $xf->step($result, $coll[$i]);
            if (Transducers::isReduced($result)) {
                $result = Transducers::deref($result);
                break;
            }
        }

        return $xf->result($result);
    }
}
