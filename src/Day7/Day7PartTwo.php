<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day7;

use Riimu\AdventOfCode2021\Typed\Arrays;

class Day7PartTwo extends AbstractDay7Task
{
    protected static string $taskName = 'Day 7: The Treachery of Whales (Part Two)';

    protected function calculateFuel(array $positions): int
    {
        $min = Arrays::min(array_keys($positions));
        $max = Arrays::max(array_keys($positions));

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

        return Arrays::min($fuel);
    }
}
