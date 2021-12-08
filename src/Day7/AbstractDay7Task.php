<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day7;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Integers;
use Riimu\AdventOfCode2021\Typed\Regex;

abstract class AbstractDay7Task extends AbstractTask
{
    public function run(): string
    {
        $inputs = array_map(
            fn (string $value): int => Integers::parse($value),
            Regex::split('/,/', $this->getInput('day-7.txt'))
        );

        sort($inputs);
        $positions = [];

        foreach ($inputs as $input) {
            $positions[$input] ??= 0;
            $positions[$input]++;
        }

        return (string)$this->calculateFuel($positions);
    }

    /**
     * @param array<int, int> $positions
     * @return int
     */
    abstract protected function calculateFuel(array $positions): int;
}
