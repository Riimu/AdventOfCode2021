<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day8;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;
use Riimu\AdventOfCode2021\Typed\Regex;

class Day8PartTwo extends AbstractTask
{
    protected static string $taskName = 'Day 8: Seven Segment Search (Part Two)';

    public function run(): string
    {
        $total = 0;

        foreach ($this->getInputLines('day-8.txt') as $line) {
            [$digitsPart, $valuePart] = Regex::split('/\\|/', $line);

            $digits = $this->detectDigits(Regex::split('/\s+/', trim($digitsPart)));
            $number = '';

            foreach (Regex::split('/\s+/', trim($valuePart)) as $value) {
                $number .= $this->findNumber($digits, $value);
            }

            $total += Integers::parse(ltrim($number, '0'));
        }

        return (string)$total;
    }

    /**
     * @param array<int, string> $digits
     * @param string $value
     * @return int
     */
    private function findNumber(array $digits, string $value): int
    {
        foreach ($digits as $number => $digit) {
            if (\strlen($value) !== \strlen($digit)) {
                continue;
            }

            if (array_diff(str_split($digit), str_split($value)) === []) {
                return $number;
            }
        }

        throw new \RuntimeException("Could not matching number for '$value'");
    }

    /**
     * @param array<int, string> $digitsStrings
     * @return array<int, string>
     */
    private function detectDigits(array $digitsStrings): array
    {
        $lengths = [];

        foreach ($digitsStrings as $segments) {
            $lengths[\strlen($segments)][] = $segments;
        }

        $digits = [];
        $digits[1] = Arrays::shift($lengths[2]);
        $digits[4] = Arrays::shift($lengths[4]);
        $digits[7] = Arrays::shift($lengths[3]);
        $digits[8] = Arrays::shift($lengths[7]);

        foreach ($lengths[6] as $key => $segments) {
            if ($this->matchingChars($digits[4], $segments, 4)) {
                $digits[9] = $segments;
                unset($lengths[6][$key]);
                break;
            }
        }

        foreach ($lengths[6] as $key => $segments) {
            if ($this->matchingChars($digits[1], $segments, 2)) {
                $digits[0] = $segments;
                unset($lengths[6][$key]);
                $digits[6] = Arrays::shift($lengths[6]);
                break;
            }
        }

        foreach ($lengths[5] as $key => $segments) {
            if ($this->matchingChars($digits[1], $segments, 2)) {
                $digits[3] = $segments;
                unset($lengths[5][$key]);
                break;
            }
        }

        foreach ($lengths[5] as $key => $segments) {
            if ($this->matchingChars($digits[4], $segments, 3)) {
                $digits[5] = $segments;
                unset($lengths[5][$key]);
                $digits[2] = Arrays::shift($lengths[5]);
            }
        }

        return $digits;
    }

    private function matchingChars(string $first, string $second, int $count): bool
    {
        return \count(array_intersect(str_split($first), str_split($second))) === $count;
    }
}
