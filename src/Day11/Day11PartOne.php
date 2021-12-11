<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day11;

use Riimu\AdventOfCode2021\Typed\Integers;

class Day11PartOne extends AbstractDay11Task
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

        $flashes = 0;

        for ($i = 0; $i < 100; $i++) {
            $flashes += $this->step($map);
        }

        return (string)$flashes;
    }
}
