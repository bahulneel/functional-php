<?php
namespace Phonon\Transducers\Transformer;

use Phonon\Transducers\Transducers;
use Phonon\Transducers\TransformerInterface;


class Take implements TransformerInterface
{

    private $n;

    /**
     *
     * @var TransformerInterface
     */
    private $xf;

    public function __construct($n, TransformerInterface $xf)
    {
        $this->n = $n;
        $this->xf = $xf;
    }

    public function init()
    {
        return $this->xf->init();
    }

    public function result($result)
    {
        return $this->xf->result($result);
    }

    public function step($result, $input)
    {
        if ($this->n > 0) {
            $result = $this->xf->step($result, $input);
        } else {
            $result = Transducers::ensureReduced($result);
        }

        $this->n -= 1;
        return $result;
    }
}
