<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day7;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Integers;
use Riimu\AdventOfCode2021\Typed\Regex;

class Day7PartOne extends AbstractTask
{
    protected static string $taskName = 'Day 7: The Treachery of Whales';

    public function run(): string
    {
        $inputs = array_map(
            fn (string $value): int => Integers::parse($value),
            Regex::split('/,/', $this->getInput('day-7.txt'))
        );

        $positions = [];

        foreach ($inputs as $input) {
            $positions[$input] ??= 0;
            $positions[$input]++;
        }

        ksort($positions);

        $fuel = array_fill_keys(array_keys($positions), 0);
        $seen = 0;
        $previous = null;
        $cumulative = 0;

        foreach ($positions as $position => $count) {
            if ($previous !== null) {
                $cumulative += ($position - $previous) * $seen;
                $fuel[$position] += $cumulative;
            }

            $seen += $count;
            $previous = $position;
        }

        $seen = 0;
        $previous = null;
        $cumulative = 0;

        foreach (array_reverse($positions, true) as $position => $count) {
            if ($previous !== null) {
                $cumulative += ($previous - $position) * $seen;
                $fuel[$position] += $cumulative;
            }

            $seen += $count;
            $previous = $position;
        }

        return (string)min($fuel);
    }
}
