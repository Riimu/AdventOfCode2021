<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day6;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Integers;
use Riimu\AdventOfCode2021\Typed\Regex;

class Day6PartOne extends AbstractTask
{
    protected static string $taskName = 'Day 6: Lanternfish';

    public function run(): string
    {
        $state = array_map(
            fn (string $value): int => Integers::parse($value),
            Regex::split('/,/', $this->getInput('day-6.txt'))
        );

        for ($i = 0; $i < 80; $i++) {
            foreach ($state as $key => $timer) {
                if ($timer === 0) {
                    $state[$key] = 6;
                    $state[] = 8;
                } else {
                    $state[$key] = $timer - 1;
                }
            }
        }

        return (string)\count($state);
    }
}
