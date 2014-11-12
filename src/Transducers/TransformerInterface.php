<?php
namespace Phonon\Transducers;

interface TransformerInterface
{
    public function init();

    public function result($result);

    public function step($result, $input);
}
