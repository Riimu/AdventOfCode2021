<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day24;

class Day24PartOne extends AbstractDay24Task
{
    protected static string $taskName = 'Day 24: Arithmetic Logic Unit';

    public function run(): string
    {
        return $this->findSerial(true);
    }
}
