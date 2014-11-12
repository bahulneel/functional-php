<?php
namespace Phonon\Schema;

class Validate extends \Phonon\Poly\MultiMethod
{
    public function getKey($args)
    {
        return $args[0];
    }

    /**
     * @Key integer
     */
    public function validateInteger($type, $value)
    {
        return is_integer($value);
    }

    /**
     * @Key float
     */
    public function validateFloat($type, $value)
    {
        return is_float($value);
    }

    /**
     * @Key number
     */
    public function validateNumber($type, $value)
    {
        return is_numeric($value);
    }

    /**
     * @Key boolean
     */
    public function validateBoolean($type, $value)
    {
        return is_bool($value);
    }

    /**
     * @Key string
     */
    public function validateString($type, $value)
    {
        return is_string($value);
    }

    /**
     * @Key null
     */
    public function validateNull($type, $value)
    {
        return is_null($value);
    }
}
