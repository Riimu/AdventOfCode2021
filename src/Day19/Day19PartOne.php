<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day19;

class Day19PartOne extends AbstractDay19Task
{
    protected static string $taskName = 'Day 19: Beacon Scanner';

    protected function calculateResult(array $scanners, array $probes): int
    {
        return \count($probes);
    }
}
