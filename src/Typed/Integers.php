<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Typed;

class Integers
{
    public static function parse(string $string): int
    {
        $value = (int)$string;

        if ($string !== (string)$value) {
            throw new \RuntimeException("Unexpected integer value '$string'");
        }

        return $value;
    }
}
