<?php
namespace Phonon\Transducers\Transformer;

use Phonon\Transducers\TransformerInterface;

class Drop implements TransformerInterface
{

    private $n;

    /**
     *
     * @var TransformerInterface
     */
    private $xf;

    public function __construct(callable $n, TransformerInterface $xf)
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
            $this->n -= 1;
            return $result;
        } else {
            return $this->xf->step($result, $input);
        }
    }
}
