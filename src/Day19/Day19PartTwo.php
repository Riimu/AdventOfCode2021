<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day19;

class Day19PartTwo extends AbstractDay19Task
{
    protected static string $taskName = 'Day 19: Beacon Scanner (Part Two)';

    protected function calculateResult(array $scanners, array $probes): int
    {
        $maxDistance = 0;

        foreach ($scanners as $pointA) {
            foreach ($scanners as $pointB) {
                $manhattanDistance =
                    abs($pointB[0] - $pointA[0]) +
                    abs($pointB[1] - $pointA[1]) +
                    abs($pointB[2] - $pointA[2]);

                $maxDistance = max($maxDistance, $manhattanDistance);
            }
        }

        return $maxDistance;
    }
}
