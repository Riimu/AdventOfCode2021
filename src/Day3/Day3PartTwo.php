<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day3;

use Riimu\AdventOfCode2021\Typed\Arrays;

class Day3PartTwo extends AbstractDay3Class
{
    protected static string $taskName = 'Day 3: Binary Diagnostic (Part Two)';

    public function run(): string
    {
        $lines = $this->getInputLines('day-3.txt');

        $oxygen = $lines;

        for ($i = 0; \count($oxygen) > 1; $i++) {
            $oneCount = $this->countPositionCharacter($oxygen, $i, '1');
            $filter = $oneCount >= \count($oxygen) / 2 ? '1' : '0';
            $oxygen = array_filter($oxygen, fn ($value) => $value[$i] === $filter);
        }

        $carbonDioxide = $lines;

        for ($i = 0; \count($carbonDioxide) > 1; $i++) {
            $oneCount = $this->countPositionCharacter($carbonDioxide, $i, '1');
            $filter = $oneCount >= \count($carbonDioxide) / 2 ? '0' : '1';
            $carbonDioxide = array_filter($carbonDioxide, fn ($value) => $value[$i] === $filter);
        }

        return (string)(bindec(Arrays::first($oxygen)) * bindec(Arrays::first($carbonDioxide)));
    }
}
