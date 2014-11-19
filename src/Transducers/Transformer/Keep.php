<?php
namespace Phonon\Transducers\Transformer;

use Phonon\Transducers\TransformerInterface;


class Keep implements TransformerInterface
{

    private $f;

    /**
     *
     * @var TransformerInterface
     */
    private $xf;

    public function __construct(callable $f, TransformerInterface $xf)
    {
        $this->f = $f;
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
        $v = call_user_func($this->f, $input);
        if ($v === null) {
            return $result;
        } else {
            return $this->xf->step($result, $v);
        }
    }
}
