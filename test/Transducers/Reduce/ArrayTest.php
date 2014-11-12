<?php
namespace Phonon\Transducers\Reduce;

use Phonon\Transducers\Transducers as t;
use PHPUnit_Framework_TestCase;

class ArrayTest extends PHPUnit_Framework_TestCase
{
    public function testArrayIntoArray()
    {
        $actual = [1, 2, 3, 4];
        $identity = function ($x) {
            return $x;
        };

        $expected = t::into(
            [],
            t::map($identity),
            $actual
        );
        
        $this->assertEquals($expected, $actual);
    }

    public function testMapFilter()
    {
        $numbers = [1, 2, 3, 4];
        $inc = function ($x) {
            return $x + 1;
        };

        $isEven = function ($x) {
            return ($x % 2) === 0;
        };
        $xf = t::comp(
            t::map($inc),
            t::filter($isEven)
        );
        $result = t::into([], $xf, $numbers);
        $this->assertEquals([2, 4], $result);
    }

    public function testMapNative()
    {
        $strings = ["hello", "world", "!"];
        $ucStrings = ["HELLO", "WORLD"];

        $result = t::into([], t::comp(
            t::map('strtoupper'),
            t::take(2)
        ), $strings);

        $this->assertEquals($ucStrings, $result);
    }

    public function testMapAssoc()
    {
        $strings = ["hello" => "world"];
        $ucStrings = [["HELLO", "world"]];

        $upperKeys = function ($item) {
            list($key, $value) = $item;
            $key = strtoupper($key);
            return [$key, $value];
        };

        $result = t::into([], t::map($upperKeys), $strings);

        $this->assertEquals($ucStrings, $result);
    }

    public function testMapIntoAssoc()
    {
        $strings = ["hello" => "world"];
        $ucStrings = ["HELLO" => "world"];

        $upperKeys = function ($item) {
            list($key, $value) = $item;
            $key = strtoupper($key);
            return [$key, $value];
        };

        $result = t::intoAssoc([], t::map($upperKeys), $strings);

        $this->assertEquals($ucStrings, $result);
    }
}
