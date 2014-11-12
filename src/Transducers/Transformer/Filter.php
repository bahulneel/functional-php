<?php
namespace Phonon\Transducers\Transformer;

use Phonon\Transducers\TransformerInterface;


class Filter implements TransformerInterface
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
            return $result;
        }
    }
}
