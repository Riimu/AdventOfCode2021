<?php

namespace Riimu\AdventOfCode2021\Day5;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Integers;
use Riimu\AdventOfCode2021\Typed\Regex;

abstract class AbstractDay5Task extends AbstractTask
{
    public function run(): string
    {
        $vents = [];

        foreach ($this->getInputLines('day-5.txt') as $line) {
            foreach ($this->parseLineCoordinates($line, $this->isStraightOnly()) as [$x, $y]) {
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

    abstract protected function isStraightOnly(): bool;

    /**
     * @param string $line
     * @return iterable<int, array<int, int>>
     */
    private function parseLineCoordinates(string $line, bool $onlyStraight): iterable
    {
        [$start, $end] = Regex::split('/\s*->\s*/', $line);
        [$startX, $startY] = $this->parseCoordinates($start);
        [$endX, $endY] = $this->parseCoordinates($end);

        if ($onlyStraight && $startX !== $endX && $startY !== $endY) {
            return;
        }

        $steps = max(abs($endX - $startX), abs($endY - $startY));

        for ($i = 0; $i < $steps; $i++) {
            yield [
                $startX + ($endX - $startX) / $steps * $i,
                $startY + ($endY - $startY) / $steps * $i,
            ];
        }

        yield [$endX, $endY];
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
