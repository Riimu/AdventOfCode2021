<?php

namespace Riimu\AdventOfCode2021\Day3;

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

        $carbondioxide = $lines;

        for ($i = 0; \count($carbondioxide) > 1; $i++) {
            $oneCount = $this->countPositionCharacter($carbondioxide, $i, '1');
            $filter = $oneCount >= \count($carbondioxide) / 2 ? '0' : '1';
            $carbondioxide = array_filter($carbondioxide, fn ($value) => $value[$i] === $filter);
        }

        return bindec(reset($oxygen)) * bindec(reset($carbondioxide));
    }
}
