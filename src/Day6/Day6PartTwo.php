<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day6;

class Day6PartTwo extends AbstractDay6Task
{
    protected static string $taskName = 'Day 6: Lanternfish (Part Two)';

    public function run(): string
    {
        return (string)$this->calculateFishAfterDays(256);
    }
}
