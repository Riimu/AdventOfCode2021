<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day13;

use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Regex;

class Day13PartOne extends AbstractDay13Task
{
    protected static string $taskName = 'Day 13: Transparent Origami';

    public function run(): string
    {
        [$coordinateInput, $foldInput] = Regex::split('/\R\R/', $this->getInput('day-13.txt'));

        $map = $this->parseMap($coordinateInput);
        $map = $this->fold($map, Arrays::first(Regex::split('/\R/', $foldInput)));

        return (string)array_reduce(
            $map,
            fn (int $carry, array $value): int => $carry + \count(array_keys($value, true, true)),
            0
        );
    }
}
