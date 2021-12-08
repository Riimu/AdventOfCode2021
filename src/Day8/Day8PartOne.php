<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day8;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Integers;
use Riimu\AdventOfCode2021\Typed\Regex;

class Day8PartOne extends AbstractTask
{
    protected static string $taskName = 'Day 8: Seven Segment Search';

    public function run(): string
    {
        $total = 0;

        foreach ($this->getInputLines('day-8.txt') as $line) {
            $valuePart = Regex::split('/\\|/', $line)[1];

            foreach (Regex::split('/\s+/', trim($valuePart)) as $segments) {
                if (\in_array(\strlen($segments), [2, 4, 3, 7])) {
                    $total++;
                }
            }
        }

        return (string)$total;
    }
}
