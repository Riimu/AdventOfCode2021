<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day17;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Integers;

class Day17PartOne extends AbstractTask
{
    protected static string $taskName = 'Day 17: Trick Shot';

    public function run(): string
    {
        $input = $this->getInput('day-17.txt');
        preg_match_all('/-?\d+/', $input, $matches);

        [$lowerX, $upperX, $lowerY, $upperY] = array_map(
            fn (string $value): int => Integers::parse($value),
            $matches[0]
        );

        $speed = abs($lowerY + 1);
        $height = 0;

        do {
            $height += $speed;
            $speed--;
        } while ($speed > 0);

        return (string)$height;
    }
}
