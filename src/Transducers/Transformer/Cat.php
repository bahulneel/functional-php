<?php
namespace Phonon\Transducers\Transformer;

use Phonon\Transducers\Transducers;
use Phonon\Transducers\TransformerInterface;


class Cat implements TransformerInterface
{

    /**
     *
     * @var TransformerInterface
     */
    private $xf;

    public function __construct(TransformerInterface $xf)
    {
        $this->xf = $xf;
        $this->rxf = new PreservingReduced($xf);
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
        return Transducers::reduce($this->rxf, $result, $input);
    }
}
