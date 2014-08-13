<?php
namespace Immutable\Benchmarks\Persistent;

use Athletic\AthleticEvent;
use Immutable\Persistent\Vector;

class VectorEvent extends AthleticEvent
{
    private $array;

    private $vector;

    public function classSetUp()
    {
        $this->array = [];
        $this->vector = new Vector;
    }

    /**
     * @iterations 10000
     */
    public function vectorAppend()
    {
        $this->vector = $this->vector->append(1);
    }

    /**
     * @iterations 10000
     */
    public function arrayAppend()
    {
        $this->array[] = 1;
    }
}
