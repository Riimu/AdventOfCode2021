<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day5;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Integers;
use Riimu\AdventOfCode2021\Typed\Regex;

class Day5PartOne extends AbstractTask
{
    protected static string $taskName = 'Day 5: Hydrothermal Venture';

    public function run(): string
    {
        $vents = [];

        foreach ($this->getInputLines('day-5.txt') as $line) {
            foreach ($this->parseLineCoordinates($line) as [$x, $y]) {
                $vents[$y][$x] ??= 0;
                $vents[$y][$x]++;
            }
        }

        $dangerous = 0;

        array_walk_recursive($vents, function (int $count) use (&$dangerous) {
            if ($count > 1) {
                $dangerous++;
            }
        });

        return (string)$dangerous;
    }

    /**
     * @param string $line
     * @return iterable<int, array<int, int>>
     */
    private function parseLineCoordinates(string $line): iterable
    {
        [$start, $end] = Regex::split('/\s*->\s*/', $line);
        [$startX, $startY] = $this->parseCoordinates($start);
        [$endX, $endY] = $this->parseCoordinates($end);

        if ($startX !== $endX && $startY !== $endY) {
            return;
        }

        $maxX = max($startX, $endX);
        $maxY = max($startY, $endY);

        for ($i = min($startX, $endX); $i < $maxX; $i++) {
            yield [$i, $startY];
        }

        for ($i = min($startY, $endY); $i < $maxY; $i++) {
            yield [$maxX, $i];
        }

        yield [$maxX, $maxY];
    }

    /**
     * @param string $value
     * @return array<int, int>
     */
    private function parseCoordinates(string $value): array
    {
        return array_map(
            fn (string $value): int => Integers::parse($value),
            Regex::split('/,/', $value)
        );
    }
}
