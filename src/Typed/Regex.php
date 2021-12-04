<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Typed;

class Regex
{
    /**
     * @param string $pattern
     * @param string $subject
     * @return array<int, string>
     */
    public static function split(string $pattern, string $subject): array
    {
        $parts = preg_split($pattern, $subject);

        if (!\is_array($parts)) {
            throw new \RuntimeException('Error in regular expression: ' . preg_last_error_msg());
        }

        return $parts;
    }
}
