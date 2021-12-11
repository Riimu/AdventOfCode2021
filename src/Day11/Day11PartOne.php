<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day11;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;

class Day11PartOne extends AbstractTask
{
    protected static string $taskName = 'Day 11: Dumbo Octopus';

    public function run(): string
    {
        $map = [];

        foreach ($this->getInputLines('day-11.txt') as $line) {
            $map[] = array_map(
                fn (string $value): int => Integers::parse($value),
                str_split($line)
            );
        }

        $maxX = \count(Arrays::first($map)) - 1;
        $maxY = \count($map) - 1;
        $flashes = 0;

        for ($i = 0; $i < 100; $i++) {
            $flash = [];

            for ($y = 0; $y <= $maxY; $y++) {
                for ($x = 0; $x <= $maxX; $x++) {
                    $map[$y][$x]++;

                    if ($map[$y][$x] === 10) {
                        $flash[] = [$x, $y];
                    }
                }
            }

            while ($flash !== []) {
                [$flashX, $flashY] = array_pop($flash);
                $flashes++;
                $map[$flashY][$flashX] = 0;

                for ($y = -1; $y <= 1; $y++) {
                    $targetY = $flashY + $y;

                    if ($targetY < 0 || $targetY > $maxY) {
                        continue;
                    }

                    for ($x = -1; $x <= 1; $x++) {
                        $targetX = $flashX + $x;

                        if ($targetX < 0 || $targetX > $maxX || $map[$targetY][$targetX] === 0) {
                            continue;
                        }

                        $map[$targetY][$targetX]++;

                        if ($map[$targetY][$targetX] === 10) {
                            $flash[] = [$targetX, $targetY];
                        }
                    }
                }
            }
        }

        return (string)$flashes;
    }
}
