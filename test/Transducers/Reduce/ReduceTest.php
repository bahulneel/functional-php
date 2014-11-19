<?php
namespace Phonon\Transducers\Reduce;

use Phonon\Transducers\Transducers as t;
use PHPUnit_Framework_TestCase;

class ReduceTest extends PHPUnit_Framework_TestCase
{
    public function testArrayIntoArray()
    {
        $actual = [1, 2, 3, 4];

        $expected = t::into(
            [],
            t::map(t::identity()),
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

    public function testMapTraversable()
    {
        $expected = [1, 2, 3, 4];
        $arr = \SplFixedArray::fromArray($expected);

        $actual = t::into(
            [],
            t::map(t::value()),
            $arr
        );

        $this->assertEquals($expected, $actual);
    }

    public function testMapString()
    {
        $expected = ["H", "e", "l", "l", "o"];

        $actual = t::into(
            [],
            t::map(t::identity()),
            "Hello"
        );

        $this->assertEquals($expected, $actual);
    }

    public function testMapStringInto()
    {
        $expected = "Hello";

        $actual = t::into(
            "",
            t::map(t::identity()),
            ["H", "e", "l", "l", "o"]
        );

        $this->assertEquals($expected, $actual);
    }

    public function testPartitionBy()
    {
        $expected = [[0,1],["foo","bar"],[2,3],["bar","baz"]];
        $xf = t::partitionBy('is_string');

        $actual = t::into([], $xf, [0,1,"foo","bar",2,3,"bar","baz"]);
        $this->assertEquals($expected, $actual);
    }

    public function testPartitionAll()
    {
        $expected = [[0,1,2],[3,4,5],[6]];
        $xf = t::partitionAll(3);
        $actual = t::into([], $xf, [0,1,2,3,4,5,6]);
        $this->assertEquals($expected, $actual);
    }

    public function testMapCat()
    {
        $input = [[0,1,2],[3,4,5],[6]];
        $expected = [0,1,2,3,4,5,6];
        $xf = t::mapcat(t::identity());
        $actual = t::into([], $xf, $input);
        $this->assertEquals($expected, $actual);
    }
}
