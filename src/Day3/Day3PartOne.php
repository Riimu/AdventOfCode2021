<?php

namespace Riimu\AdventOfCode2021\Day3;

class Day3PartOne extends AbstractDay3Class
{
    protected static string $taskName = 'Day 3: Binary Diagnostic';

    public function run(): string
    {
        $lines = $this->getInputLines('day-3.txt');

        $first = reset($lines);

        if (!\is_string($first)) {
            throw new \RuntimeException('No input lines provided');
        }

        $length = \strlen($first);
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
