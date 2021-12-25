<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day24;

interface AluRunner
{
    /**
     * @param array<int, int> $input
     * @return int
     */
    public function calculate(array $input): int;
}
