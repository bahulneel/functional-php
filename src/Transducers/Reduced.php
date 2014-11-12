<?php
namespace Phonon\Transducers;

class Reduced implements HasValueInterface
{

    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
