<?php

namespace Riimu\AdventOfCode2021\Day2;

use Riimu\AdventOfCode2021\AbstractTask;

class Day2PartTwo extends AbstractTask
{
    protected static string $taskName = 'Day 2: Dive! (Part Two)';

    public function run(): string
    {
        $depth = 0;
        $distance = 0;
        $aim = 0;

        foreach ($this->getInputLines('day-2.txt') as $line) {
            [$command, $value] = explode(' ', $line);

            $value = (int)$value;

            switch ($command) {
                case 'forward':
                    $distance += $value;
                    $depth += $value * $aim;
                    break;
                case 'down':
                    $aim += $value;
                    break;
                case 'up':
                    $aim -= $value;
                    break;
            }
        }

        return (string)($depth * $distance);
    }
}
