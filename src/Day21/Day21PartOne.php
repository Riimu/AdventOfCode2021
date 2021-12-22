<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day21;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;
use Riimu\AdventOfCode2021\Typed\Regex;

class Day21PartOne extends AbstractTask
{
    protected static string $taskName = 'Day 21: Dirac Dice';

    public function run(): string
    {
        $players = [];
        $score = [];

        foreach ($this->getInputLines('day-21.txt') as $line) {
            $players[] = Integers::parse(Regex::split('/\s*:\s*/', $line)[1]) - 1;
            $score[] = 0;
        }

        $roll = 0;
        $rolls = 0;
        $current = 0;
        $playerCount = \count($players);

        do {
            $movement = 0;

            for ($i = 0; $i < 3; $i++) {
                $movement += $roll + 1;
                $roll = ($roll + 1) % 100;
                $rolls++;
            }

            $players[$current] = ($players[$current] + $movement) % 10;
            $score[$current] += $players[$current] + 1;
            $current = ($current + 1) % $playerCount;
        } while (Arrays::max($score) < 1000);

        return (string)(Arrays::min($score) * $rolls);
    }
}
