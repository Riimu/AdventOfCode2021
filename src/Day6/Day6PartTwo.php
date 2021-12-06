<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day6;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Integers;
use Riimu\AdventOfCode2021\Typed\Regex;

class Day6PartTwo extends AbstractTask
{
    protected static string $taskName = 'Day 6: Lanternfish (Part Two)';

    public function run(): string
    {
        $inputs = array_map(
            fn (string $value): int => Integers::parse($value),
            Regex::split('/,/', $this->getInput('day-6.txt'))
        );

        $states = array_fill(0, 9, 0);

        foreach ($inputs as $input) {
            $states[$input]++;
        }

        for ($i = 0; $i < 256; $i++) {
            $newState = array_fill(0, 9, 0);

            for ($j = 0; $j < 8; $j++) {
                $newState[$j] = $states[$j + 1];
            }

            $newState[8] = $states[0];
            $newState[6] += $states[0];

            $states = $newState;
        }

        return (string)\array_sum($states);
    }
}
