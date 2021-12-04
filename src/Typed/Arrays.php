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
        $key = array_key_first($array);

        if (!\is_string($key) && !\is_int($key)) {
            throw new \InvalidArgumentException('Cannot return first element of empty array');
        }

        return $array[$key];
    }

    /**
     * @template T
     * @param array<T> $array
     * @return T
     */
    public static function last(array $array): mixed
    {
        $key = array_key_last($array);

        if (!\is_string($key) && !\is_int($key)) {
            throw new \InvalidArgumentException('Cannot return first element of empty array');
        }

        return $array[$key];
    }
}
