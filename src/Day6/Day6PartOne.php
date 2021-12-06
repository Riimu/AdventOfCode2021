<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day6;

class Day6PartOne extends AbstractDay6Task
{
    protected static string $taskName = 'Day 6: Lanternfish';

    public function run(): string
    {
        return (string)$this->calculateFishAfterDays(80);
    }
}
