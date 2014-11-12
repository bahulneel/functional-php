<?php
namespace Phonon\Schema;

class Validator
{
    /**
     *
     * @var callable
     */
    private $validate;

    private function __construct(callable $validate)
    {
        $this->validate = $validate;
    }

    public static function create()
    {
        return new self (new Validate);
    }

    public function __invoke($type, $value)
    {
        $v = $this->validate;
        if ($v($type, $value)) {
            return $value;
        }
        throw new \RuntimeException("Value does not match Schema: " . strval($value) . " != " . $type);
    }
}
