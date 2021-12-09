<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day9;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;

class Day9PartTwo extends AbstractTask
{
    protected static string $taskName = 'Day 9: Smoke Basin (Part Two)';

    public function run(): string
    {
        $map = [];

        foreach ($this->getInputLines('day-9.txt') as $line) {
            $map[] = array_map(
                fn (string $number): int => Integers::parse($number),
                str_split(trim($line))
            );
        }

        $visited = [];
        $basins = [];

        $maxY = \count($map) - 1;
        $maxX = \count(Arrays::first($map)) - 1;

        foreach ($map as $mapY => $row) {
            foreach ($row as $mapX => $height) {
                if ($height === 9 || isset($visited[$mapY][$mapX])) {
                    continue;
                }

                $size = 0;
                $points = [[$mapX, $mapY]];
                $visited[$mapY][$mapX] = true;

                do {
                    /** @var array<int, array<int, int>> $points */
                    [$x, $y] = Arrays::shift($points);
                    $size++;

                    if ($x !== 0 && !isset($visited[$y][$x - 1]) && $map[$y][$x - 1] !== 9) {
                        $visited[$y][$x - 1] = true;
                        $points[] = [$x - 1, $y];
                    }
                    if ($x !== $maxX && !isset($visited[$y][$x + 1]) && $map[$y][$x + 1] !== 9) {
                        $visited[$y][$x + 1] = true;
                        $points[] = [$x + 1, $y];
                    }
                    if ($y !== 0 && !isset($visited[$y - 1][$x]) && $map[$y - 1][$x] !== 9) {
                        $visited[$y - 1][$x] = true;
                        $points[] = [$x, $y - 1];
                    }
                    if ($y !== $maxY && !isset($visited[$y + 1][$x]) && $map[$y + 1][$x] !== 9) {
                        $visited[$y + 1][$x] = true;
                        $points[] = [$x, $y + 1];
                    }
                } while ($points !== []);

                $basins[] = $size;
            }
        }

        rsort($basins);

        return (string)array_product(\array_slice($basins, 0, 3));
    }
}
