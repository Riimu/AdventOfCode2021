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

    public static function replace(string $pattern, string $replace, string $subject): string
    {
        $replaced = preg_replace($pattern, $replace, $subject);

        if (!\is_string($replaced)) {
            throw new \RuntimeException('Error in regular expression: ' . preg_last_error_msg());
        }

        return $replaced;
    }

    /**
     * @param string $pattern
     * @param string $subject
     * @return list<string>
     */
    public static function findAll(string $pattern, string $subject): array
    {
        $count = preg_match_all($pattern, $subject, $matches);

        if ($count === false || $count !== \count($matches[0])) {
            throw new \RuntimeException('Error in regular expression: ' . preg_last_error_msg());
        }

        return $matches[0];
    }
}
