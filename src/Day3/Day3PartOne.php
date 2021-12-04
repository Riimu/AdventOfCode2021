<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day3;

use Riimu\AdventOfCode2021\Typed\Arrays;

class Day3PartOne extends AbstractDay3Class
{
    protected static string $taskName = 'Day 3: Binary Diagnostic';

    public function run(): string
    {
        $lines = $this->getInputLines('day-3.txt');
        $length = \strlen(Arrays::first($lines));
        $gamma = '';
        $epsilon = '';
        $majority = \count($lines) / 2;

        for ($i = 0; $i < $length; $i++) {
            $oneMostCommon = $this->countPositionCharacter($lines, $i, '1') > $majority;
            $gamma .= $oneMostCommon ? '1' : '0';
            $epsilon .= $oneMostCommon ? '0' : '1';
        }

        return (string)(bindec($gamma) * bindec($epsilon));
    }
}
