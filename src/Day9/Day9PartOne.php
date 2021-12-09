<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day9;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;

class Day9PartOne extends AbstractTask
{
    protected static string $taskName = 'Day 9: Smoke Basin';

    public function run(): string
    {
        $map = [];

        foreach ($this->getInputLines('day-9.txt') as $line) {
            $map[] = array_map(
                fn (string $number): int => Integers::parse($number),
                str_split(trim($line))
            );
        }

        $totalRisk = 0;
        $maxY = \count($map) - 1;
        $maxX = \count(Arrays::first($map)) - 1;

        foreach ($map as $y => $row) {
            foreach ($row as $x => $height) {
                if (
                    ($x === 0 || $height < $row[$x - 1]) &&
                    ($x === $maxX || $height < $row[$x + 1]) &&
                    ($y === 0 || $height < $map[$y - 1][$x]) &&
                    ($y === $maxY || $height < $map[$y + 1][$x])
                ) {
                    $totalRisk += $height + 1;
                }
            }
        }

        return (string)$totalRisk;
    }
}
