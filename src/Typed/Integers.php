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

    /**
     * @param string $string
     * @return array<int, int>
     */
    public static function parseAll(string $string): array
    {
        return array_map(
            fn (string $value): int => self::parse($value),
            Regex::findAll('/-?\d+/', $string)
        );
    }

    public static function fromBinary(string $binary): int
    {
        $number = bindec($binary);

        if (!\is_int($number)) {
            throw new \RuntimeException("Unexpected binary number '$binary'");
        }

        return $number;
    }

    /**
     * @param int $from
     * @param int $to
     * @return array<int, int>
     */
    public static function range(int $from, int $to): array
    {
        return range($from, $to);
    }
}
