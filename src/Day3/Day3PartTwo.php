<?php

namespace Riimu\AdventOfCode2021\Day3;

use Riimu\AdventOfCode2021\AbstractTask;

class Day3PartTwo extends AbstractTask
{
    protected static string $taskName = 'Day 3: Binary Diagnostic (Part Two)';

    public function run(): string
    {
        $lines = $this->getInputLines('day-3.txt');

        $oxygen = $lines;

        for ($i = 0; count($oxygen) > 1; $i++) {
            $ones = $this->getOneCounts($oxygen);
            $filter = $ones[$i] >= count($oxygen) / 2 ? '1' : '0';
            $oxygen = array_filter($oxygen, fn ($value) => $value[$i] === $filter);
        }

        $carbondioxide = $lines;

        for ($i = 0; count($carbondioxide) > 1; $i++) {
            $ones = $this->getOneCounts($carbondioxide);
            $filter = $ones[$i] >= count($carbondioxide) / 2 ? '0' : '1';
            $carbondioxide = array_filter($carbondioxide, fn ($value) => $value[$i] === $filter);
        }

        return bindec(reset($oxygen)) * bindec(reset($carbondioxide));
    }

    private function getOneCounts(array $lines): array
    {
        $ones = array_fill(0, \strlen(reset($lines)), 0);

        foreach ($lines as $line) {
            foreach (str_split($line) as $position => $character) {
                if ($character === '1') {
                    $ones[$position]++;
                }
            }
        }

        return $ones;
    }
}
