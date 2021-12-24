<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day24;

class Day24PartTwo extends AbstractDay24Task
{
    protected static string $taskName = 'Day 24: Arithmetic Logic Unit (Part Two)';

    public function run(): string
    {
        return $this->findSerial(false);
    }
}
