<?php

namespace Riimu\AdventOfCode2021\Day1;

use Riimu\AdventOfCode2021\AbstractTask;

class Day1PartTwo extends AbstractTask
{
    protected static string $taskName = 'Day 1: Sonar Sweep (Part Two)';

    public function run(): string
    {
        $total = 0;
        $windows = [];

        foreach ($this->getInputLines('day-1.txt') as $number => $line) {
            $depth = (int)$line;

            for ($i = 0; $i < 3; $i++) {
                if (!isset($windows[$number + $i])) {
                    $windows[$number + $i] = 0;
                }

                $windows[$number + $i] += $depth;
            }

            if ($number > 3 && $windows[$number - 2] > $windows[$number - 3]) {
                $total++;
            }
        }

        return (string)$total;
    }
}
