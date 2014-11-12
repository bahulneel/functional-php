<?php
namespace Phonon\Transducers\Transformer;

use Phonon\Transducers\TransformerInterface;


class TakeNth implements TransformerInterface
{

    private $n;
    private $i;

    /**
     *
     * @var TransformerInterface
     */
    private $xf;

    public function __construct(callable $n, TransformerInterface $xf)
    {
        $this->i = -1;
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
        $this->i += 1;
        if (($this->i % $this->n) === 0) {
            return $this->xf->step($result, $input);
        } else {
            return $result;
        }
    }
}
