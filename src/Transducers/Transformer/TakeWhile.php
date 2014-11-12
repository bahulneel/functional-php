<?php
namespace Phonon\Transducers\Transformer;

use Phonon\Transducers\Transducers;
use Phonon\Transducers\TransformerInterface;


class TakeWhile implements TransformerInterface
{

    private $pred;

    /**
     *
     * @var TransformerInterface
     */
    private $xf;

    public function __construct(callable $pred, TransformerInterface $xf)
    {
        $this->pred = $pred;
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
        if (call_user_func($this->pred, $input)) {
            return $this->xf->step($result, $input);
        } else {
            return Transducers::reduced($result);
        }
    }
}
