<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day1;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Integers;

class Day1PartOne extends AbstractTask
{
    protected static string $taskName = 'Day 1: Sonar Sweep';

    public function run(): string
    {
        $total = 0;
        $previous = null;

        foreach ($this->getInputLines('day-1.txt') as $line) {
            $depth = Integers::parse($line);

            if ($previous !== null && $depth > $previous) {
                $total++;
            }

            $previous = $depth;
        }

        return (string)$total;
    }
}
