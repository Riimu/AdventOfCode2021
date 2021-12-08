<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day7;

use Riimu\AdventOfCode2021\Typed\Arrays;

class Day7PartOne extends AbstractDay7Task
{
    protected static string $taskName = 'Day 7: The Treachery of Whales';

    protected function calculateFuel(array $positions): int
    {
        $fuel = array_fill_keys(array_keys($positions), 0);
        $seen = 0;
        $previous = 0;
        $cumulative = 0;

        foreach ($positions as $position => $count) {
            if ($seen > 0) {
                $cumulative += ($position - $previous) * $seen;
                $fuel[$position] += $cumulative;
            }

            $seen += $count;
            $previous = $position;
        }

        $seen = 0;
        $previous = 0;
        $cumulative = 0;

        foreach (array_reverse($positions, true) as $position => $count) {
            if ($seen > 0) {
                $cumulative += ($previous - $position) * $seen;
                $fuel[$position] += $cumulative;
            }

            $seen += $count;
            $previous = $position;
        }

        return Arrays::min($fuel);
    }
}
