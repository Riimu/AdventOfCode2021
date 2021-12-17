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

    public static function fromBinary(string $binary): int
    {
        $number = bindec($binary);

        if (!\is_int($number)) {
            throw new \RuntimeException("Unexpected binary number '$binary'");
        }

        return $number;
    }
}
