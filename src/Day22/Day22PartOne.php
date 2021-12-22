<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day22;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;

class Day22PartOne extends AbstractTask
{
    protected static string $taskName = 'Day 22: Reactor Reboot';

    public function run(): string
    {
        $cubes = [];

        foreach ($this->getInputLines('day-22.txt') as $line) {
            $turnOn = str_starts_with($line, 'on');
            [$x1, $x2, $y1, $y2, $z1, $z2] = Integers::parseAll($line);

            if ($x1 > 50 || $x2 < -50 || $y1 > 50 || $y2 < -50 || $z1 > 50 || $z2 < -50) {
                continue;
            }

            for ($z = $z1; $z <= $z2; $z++) {
                for ($y = $y1; $y <= $y2; $y++) {
                    for ($x = $x1; $x <= $x2; $x++) {
                        $cubes[$z][$y][$x] = $turnOn;
                    }
                }
            }
        }

        return (string)Arrays::countRecursive($cubes, true);
    }
}
