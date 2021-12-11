<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day11;

use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;

class Day11PartTwo extends AbstractDay11Task
{
    protected static string $taskName = 'Day 11: Dumbo Octopus (Part Two)';

    public function run(): string
    {
        $map = [];

        foreach ($this->getInputLines('day-11.txt') as $line) {
            $map[] = array_map(
                fn (string $value): int => Integers::parse($value),
                str_split($line)
            );
        }

        $total = \count($map) * \count(Arrays::first($map));
        $step = 0;

        do {
            $step++;
            $flashes = $this->step($map);
        } while ($flashes < $total);

        return (string)$step;
    }
}
