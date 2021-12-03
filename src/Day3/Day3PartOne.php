<?php

namespace Riimu\AdventOfCode2021\Day3;

use Riimu\AdventOfCode2021\AbstractTask;

class Day3PartOne extends AbstractTask
{
    protected static string $taskName = 'Day 3: Binary Diagnostic';

    public function run(): string
    {
        $lines = $this->getInputLines('day-3.txt');
        $ones = array_fill(0, \strlen(reset($lines)), 0);

        foreach ($lines as $line) {
            foreach (str_split($line) as $position => $character) {
                if ($character === '1') {
                    $ones[$position]++;
                }
            }
        }

        $gamma = '';
        $epsilon = '';
        $majority = count($lines) / 2;

        foreach ($ones as $count) {
            $gamma .= $count >= $majority ? '1' : '0';
            $epsilon .= $count >= $majority ? '0' : '1';
        }

        return bindec($gamma) * bindec($epsilon);
    }
}
