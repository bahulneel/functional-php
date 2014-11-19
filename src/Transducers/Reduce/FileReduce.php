<?php
namespace Phonon\Transducers\Reduce;

use Phonon\Transducers\ReduceInterface;
use Phonon\Transducers\Transducers;
use Phonon\Transducers\TransformerInterface;

class FileReduce implements ReduceInterface
{
    public static function reduce($coll, TransformerInterface $xf, $init)
    {
        $result = $init;

        while (!feof($coll)) {
            $item = fgets($coll, 8196);
            $result = $xf->step($result, $item);
            if (Transducers::isReduced($result)) {
                $result = Transducers::deref($result);
                break;
            }
        }

        return $xf->result($result);
    }
}
