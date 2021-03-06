<?php
namespace Phonon\Transducers\Reduce;

use Phonon\Transducers\ReduceInterface;
use Phonon\Transducers\Transducers;
use Phonon\Transducers\TransformerInterface;

class ArrayReduce implements ReduceInterface
{
    public static function reduceArray($coll, TransformerInterface $xf, $init)
    {

        $result = array_reduce($coll, function($result, $input) use ($xf) {
            if (Transducers::isReduced($result)) {
                return $result;
            }
            return $xf->step($result, $input);
        }, $init);

        if (Transducers::isReduced($result)) {
            $result = Transducers::deref($result);
        }

        return $xf->result($result);
    }

    public static function reduce($coll, TransformerInterface $xf, $init)
    {
        $isAssoc = Transducers::isAssoc($coll);
        if ($isAssoc) {
            return TraversableReduce::reduce($coll, $xf, $init);
        } else {
            return self::reduceArray($coll, $xf, $init);
        }
    }
}
