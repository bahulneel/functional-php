<?php
namespace Phonon\Transducers\Reduce;

use Phonon\Transducers\Pair;
use Phonon\Transducers\ReduceInterface;
use Phonon\Transducers\Transducers;
use Phonon\Transducers\TransformerInterface;

class TraversableReduce implements ReduceInterface
{

    public static function reduce($coll, TransformerInterface $xf, $init)
    {
        $result = $init;

        foreach ($coll as $key => $value) {
            $result = $xf->step($result, new Pair([$key, $value]));
            if (Transducers::isReduced($result)) {
                $result = Transducers::deref($result);
                break;
            }
        }

        return $xf->result($result);
    }
}
