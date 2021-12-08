<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Typed;

class Arrays
{
    /**
     * @template T
     * @param array<T> $array
     * @return T
     */
    public static function first(array $array): mixed
    {
        if ($array === []) {
            throw new \InvalidArgumentException('Cannot return the first element of an empty array');
        }

        return $array[array_key_first($array)];
    }

    /**
     * @template T
     * @param array<T> $array
     * @return T
     */
    public static function last(array $array): mixed
    {
        if ($array === []) {
            throw new \InvalidArgumentException('Cannot return the last element of an empty array');
        }

        return $array[array_key_last($array)];
    }

    /**
     * @template T
     * @param array<T> $array
     * @return T
     */
    public static function shift(array &$array): mixed
    {
        if ($array === []) {
            throw new \InvalidArgumentException('Cannot shift the first element of an empty array');
        }

        return array_shift($array);
    }

    /**
     * @template T
     * @param array<T> $array
     * @return T
     */
    public static function min(array $array): mixed
    {
        if ($array === []) {
            throw new \InvalidArgumentException('Cannot return the minimum value of an empty array');
        }

        return min($array);
    }

    /**
     * @template T
     * @param array<T> $array
     * @return T
     */
    public static function max(array $array): mixed
    {
        if ($array === []) {
            throw new \InvalidArgumentException('Cannot return the maximum value of an empty array');
        }

        return max($array);
    }
}
