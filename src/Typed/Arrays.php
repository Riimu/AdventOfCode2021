<?php

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

        if ($key === null) {
            throw new \InvalidArgumentException('Cannot return first element of empty array');
        }

        return $array[$key];
    }
}
