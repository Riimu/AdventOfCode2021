<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day7;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;
use Riimu\AdventOfCode2021\Typed\Regex;

class Day7PartTwo extends AbstractTask
{
    protected static string $taskName = 'Day 7: The Treachery of Whales';

    public function run(): string
    {
        $inputs = array_map(
            fn (string $value): int => Integers::parse($value),
            Regex::split('/,/', $this->getInput('day-7.txt'))
        );

        sort($inputs);
        $positions = [];

        foreach ($inputs as $input) {
            $positions[$input] ??= 0;
            $positions[$input]++;
        }

        $min = Arrays::first($inputs);
        $max = Arrays::last($inputs);

        $fuel = [$min => 0];
        $seen = $positions[$min];
        $cost = 0;
        $cumulative = 0;

        for ($i = $min + 1; $i <= $max; $i++) {
            $cost += $seen;
            $cumulative += $cost;
            $fuel[$i] = $cumulative;
            $seen += $positions[$i] ?? 0;
        }

        $seen = $positions[$max];
        $cost = 0;
        $cumulative = 0;

        for ($i = $max - 1; $i >= $min; $i--) {
            $cost += $seen;
            $cumulative += $cost;
            $fuel[$i] += $cumulative;
            $seen += $positions[$i] ?? 0;
        }

        return (string)min($fuel);
    }
}
