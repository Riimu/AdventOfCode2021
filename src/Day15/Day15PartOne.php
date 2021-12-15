<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day15;

use Riimu\AdventOfCode2021\Typed\Integers;

class Day15PartOne extends AbstractDay15Task
{
    protected static string $taskName = 'Day 15: Chiton';

    public function run(): string
    {
        $map = [];

        foreach ($this->getInputLines('day-15.txt') as $line) {
            $row = array_map(
                fn (string $value): int => Integers::parse($value),
                str_split($line)
            );

            $map[] = $row;
        }

        return (string)$this->solveMap($map);
    }
}
