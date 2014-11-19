<?php
namespace Phonon\Transducers;

Reduce::extend(gettype([]), "\Phonon\Transducers\Reduce\ArrayReduce");
Reduce::extend(gettype(""), "\Phonon\Transducers\Reduce\StringReduce");
Reduce::extend("resource", "\Phonon\Transducers\Reduce\FileReduce");
Reduce::extend("Traversable", "\Phonon\Transducers\Reduce\TraversableReduce");
Into::extend(gettype([]), "\Phonon\Transducers\Into\ArrayInto");
Into::extend(gettype(""), "\Phonon\Transducers\Into\StringInto");

class Transducers
{
    public static function wrap(callable $stepFn)
    {
        return new Transformer\Wrap($stepFn);
    }

    public static function reduced($value)
    {
        return new Reduced($value);
    }

    public static function isReduced($value)
    {
        return ($value instanceof Reduced);
    }

    public static function ensureReduced($value)
    {
        if (self::isReduced($value)) {
            return $value;
        }

        return self::reduced($value);
    }

    public static function deref($value)
    {
        if ($value instanceof HasValueInterface) {
            return $value->getValue();
        }

        return null;
    }

    public static function unreduced($value)
    {
        if (self::isReduced($value)) {
            return self::dref($value);
        }

        return $value;
    }

    public static function isAssoc($arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    public static function complement(callable $f)
    {
        return function () use ($f) {
            return !call_user_func_array($f, func_get_args());
        };
    }

    public static function comp()
    {
        $args = func_get_args();
        $argLen = count($args);

        if ($argLen === 2) {
            $f = $args[0];
            $g = $args[1];

            return function () use ($f, $g) {
                $args = func_get_args();
                
                return call_user_func(
                    $f,
                    call_user_func_array($g, $args)
                );
            };
        }

        if ($argLen > 2) {
            $first = array_shift($args);
            return self::reduce(["Transducers", "comp"], $first, $args);
        }

        throw new \RuntimeException("comp must given at least 2 arguments");
    }

    public static function map(callable $f)
    {
        return function (TransformerInterface $xf) use ($f) {
            return new Transformer\Map($f, $xf);
        };
    }

    public static function keep(callable $f)
    {
        return function (TransformerInterface $xf) use ($f) {
            return new Transformer\Keep($f, $xf);
        };
    }

    public static function filter(callable $pred)
    {
        return function (TransformerInterface $xf) use ($pred) {
            return new Transformer\Filter($pred, $xf);
        };
    }

    public static function remove(callable $pred)
    {
        return function (TransformerInterface $xf) use ($pred) {
            return new Transformer\Filter(self::complement($pred), $xf);
        };
    }

    public static function take($n)
    {
        return function (TransformerInterface $xf) use ($n) {
            return new Transformer\Take($n, $xf);
        };
    }

    public static function takeWhile(callable $pred)
    {
        return function (TransformerInterface $xf) use ($pred) {
            return new Transformer\TakeWhile($pred, $xf);
        };
    }

    public static function takeNth($n)
    {
        return function (TransformerInterface $xf) use ($n) {
            return new Transformer\TakeNth($n, $xf);
        };
    }

    public static function drop($n)
    {
        return function (TransformerInterface $xf) use ($n) {
            return new Transformer\Drop($n, $xf);
        };
    }

    public static function dropWhile(callable $pred)
    {
        return function (TransformerInterface $xf) use ($pred) {
            return new Transformer\DropWhile($pred, $xf);
        };
    }

    /** Partition et al. **/

    public static function reduce($xf, $init, $coll)
    {
        if (is_callable($xf)) {
            $xf = self::wrap($xf);
        }
        return Reduce::reduce($coll, $xf, $init);
    }

    public static function transduce($xf, $f, $init, $coll)
    {
        if (is_callable($f)) {
            $f = self::wrap($f);
        }

        $xf = call_user_func($xf, $f);
        
        return self::reduce($xf, $init, $coll);
    }

    public static function into($empty, $xf, $coll)
    {
        return Into::into($empty, $xf, $coll);
    }

    public static function intoAssoc($empty, $xf, $coll)
    {
        return self::transduce(
            $xf,
            function ($arr, $item) {
                list($key, $value) = $item;
                $arr[$key] = $value;
                return $arr;
            },
            $empty,
            $coll
        );
    }

    public static function identity()
    {
        return function ($x) {
            return $x;
        };
    }

    public static function key($index = 0)
    {
        return function ($x) {
            return $x[$index];
        };
    }

    public static function value()
    {
        return function ($x) {
            if ($x instanceof Pair) {
                return $x[1];
            }
            return $x;
        };
    }
}
