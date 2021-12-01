<?php

namespace Riimu\AdventOfCode2021\Day1;

use Riimu\AdventOfCode2021\AbstractTask;

class Day1PartOne extends AbstractTask
{
    public function run(): string
    {
        $total = 0;
        $previous = null;

        foreach ($this->getInputLines('day-1.txt') as $line) {
            $depth = (int)$line;

            if ($previous !== null && $depth > $previous) {
                $total++;
            }

            $previous = $depth;
        }

        return (string)$total;
    }
}
