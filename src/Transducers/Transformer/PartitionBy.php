<?php
namespace Phonon\Transducers\Transformer;

use Phonon\Transducers\Transducers;
use Phonon\Transducers\TransformerInterface;


class PartitionBy implements TransformerInterface
{

    private $f;

    /**
     *
     * @var TransformerInterface
     */
    private $xf;
    private $a;
    private $pval;

    public function __construct(callable $f, TransformerInterface $xf)
    {
        $this->f = $f;
        $this->xf = $xf;
        $this->a = [];
        $this->pval = Transducers::none();
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
        $pval = $this->pval;
        $val = call_user_func($this->f, $input);

        $this->pval = $val;

        $none = Transducers::none();
        if ($pval === $none || $pval === $val) {
            $this->a[] = $input;
            return $result;
        }
        $ret = $this->xf->step($result, $this->a);
        $this->a = [];
        if (!Transducers::isReduced($ret)) {
            $this->a[] = $input;
        }
        return $ret;
    }
}
