<?php
namespace Phonon\Transducers\Transformer;

use Phonon\Transducers\Transducers;
use Phonon\Transducers\TransformerInterface;


class PartitionAll implements TransformerInterface
{

    private $n;

    /**
     *
     * @var TransformerInterface
     */
    private $xf;
    private $a;

    public function __construct($n, TransformerInterface $xf)
    {
        $this->n = $n;
        $this->xf = $xf;
        $this->a = [];
    }

    public function init()
    {
        return $this->xf->init();
    }

    public function result($result)
    {
        if (count($this->a) > 0) {
            $result = Transducers::unreduced($this->xf->step($result, $this->a));
            $this->a = [];
        }
        return $this->xf->result($result);
    }

    public function step($result, $input)
    {
        $this->a[] = $input;
        if (count($this->a) === $this->n) {
            $a = $this->a;
            $this->a = [];
            return $this->xf->step($result, $a);
        } else {
            return $result;
        }
    }
}
