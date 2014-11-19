<?php
namespace Phonon\Transducers\Transformer;

use Phonon\Transducers\Transducers;
use Phonon\Transducers\TransformerInterface;


class PreservingReduced implements TransformerInterface
{

    /**
     *
     * @var TransformerInterface
     */
    private $xf;

    public function __construct(TransformerInterface $xf)
    {
        $this->xf = $xf;
    }

    public function init()
    {
        return $this->xf->init();
    }

    public function result($result)
    {
        return $result;
    }

    public function step($result, $input)
    {
        $ret = $this->xf->step($result, $input);
        if (Transducers::isReduced($ret)) {
            return Transducers::reduced($ret);
        }
        return $ret;
    }
}
