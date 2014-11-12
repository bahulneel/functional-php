<?php
namespace Phonon\Transducers\Transformer;

use Phonon\Transducers\TransformerInterface;


class DropWhile implements TransformerInterface
{

    private $pred;
    private $drop;

    /**
     *
     * @var TransformerInterface
     */
    private $xf;

    public function __construct(callable $pred, TransformerInterface $xf)
    {
        $this->drop = true;
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
        if ($this->drop && call_user_func($this->pred, $input)) {
            return $result;
        } else {
            if ($this->drop) {
                $this->drop = false;
            }
            return $this->xf->step($result, $input);
        }
    }
}
