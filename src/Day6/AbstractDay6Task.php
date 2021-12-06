<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day6;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Integers;
use Riimu\AdventOfCode2021\Typed\Regex;

abstract class AbstractDay6Task extends AbstractTask
{
    protected function calculateFishAfterDays(int $days): int
    {
        $inputs = array_map(
            fn (string $value): int => Integers::parse($value),
            Regex::split('/,/', $this->getInput('day-6.txt'))
        );

        $states = array_fill(0, 9, 0);

        foreach ($inputs as $input) {
            $states[$input]++;
        }

        for ($i = 0; $i < $days; $i++) {
            $newState = array_fill(0, 9, 0);

            for ($j = 0; $j < 8; $j++) {
                $newState[$j] = $states[$j + 1];
            }

            $newState[8] = $states[0];
            $newState[6] += $states[0];

            $states = $newState;
        }

        return array_sum($states);
    }
}
