<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day5;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Integers;
use Riimu\AdventOfCode2021\Typed\Regex;

class Day5PartTwo extends AbstractDay5Task
{
    protected static string $taskName = 'Day 5: Hydrothermal Venture';

    protected function isStraightOnly(): bool
    {
        return false;
    }
}
