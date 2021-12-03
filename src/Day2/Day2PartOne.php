<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day2;

use Riimu\AdventOfCode2021\AbstractTask;

class Day2PartOne extends AbstractTask
{
    protected static string $taskName = 'Day 2: Dive!';

    public function run(): string
    {
        $depth = 0;
        $distance = 0;

        foreach ($this->getInputLines('day-2.txt') as $line) {
            [$command, $value] = explode(' ', $line);

            $value = $this->parseInt($value);

            switch ($command) {
                case 'forward':
                    $distance += $value;
                    break;
                case 'down':
                    $depth += $value;
                    break;
                case 'up':
                    $depth -= $value;
                    break;
            }
        }

        return (string)($depth * $distance);
    }
}
