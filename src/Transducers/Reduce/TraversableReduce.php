<?php
namespace Phonon\Transducers\Reduce;

use Phonon\Transducers\ReduceInterface;
use Phonon\Transducers\Transducers;
use Phonon\Transducers\TransformerInterface;

class TraversableReduce implements ReduceInterface
{

    public static function reduce($coll, TransformerInterface $xf, $init)
    {
        $result = $init;

        foreach ($coll as $key => $value) {
            $result = $xf->step($result, [$key, $value]);
            if (Transducers::isReduced($result)) {
                $result = Transducers::deref($result);
                break;
            }
        }

        return $xf->result($result);
    }
}
