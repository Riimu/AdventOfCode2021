<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day15;

use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;

class Day15PartTwo extends AbstractDay15Task
{
    protected static string $taskName = 'Day 15: Chiton (Part Two)';

    public function run(): string
    {
        $map = [];
        $tile = [];

        foreach ($this->getInputLines('day-15.txt') as $line) {
            $row = array_map(
                fn (string $value): int => Integers::parse($value),
                str_split($line)
            );

            $tile[] = $row;
        }

        $tileWidth = \count(Arrays::first($tile));
        $tileHeight = \count($tile);

        for ($i = 0; $i < 5; $i++) {
            for ($j = 0; $j < 5; $j++) {
                foreach ($tile as $y => $row) {
                    foreach ($row as $x => $value) {
                        $map[$i * $tileHeight + $y][$j * $tileWidth + $x] = ($value + $i + $j) % 9 ?: 9;
                    }
                }
            }
        }

        return (string)$this->solveMap($map);
    }
}
