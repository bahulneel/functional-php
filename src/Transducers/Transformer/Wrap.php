<?php
namespace Phonon\Transducers\Transformer;

use Phonon\Transducers\TransformerInterface;
use RuntimeException;

class Wrap implements TransformerInterface
{
    private $stepFn;

    public function __construct(callable $stepFn)
    {
        $this->stepFn = $stepFn;
    }

    public function init()
    {
        throw new RuntimeException('init not implemented');
    }

    public function result($result)
    {
        return $result;
    }

    public function step($result, $input)
    {
        return call_user_func($this->stepFn, $result, $input);
    }
}
