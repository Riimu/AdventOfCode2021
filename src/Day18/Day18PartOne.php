<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day18;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;

class Day18PartOne extends AbstractTask
{
    protected static string $taskName = 'Day 18: Snailfish';

    public function run(): string
    {
        $parser = new SnailfishParser();
        $lines = $this->getInputLines('day-18.txt');

        $result = $parser->parse(Arrays::shift($lines));

        foreach ($lines as $line) {
            $result->add($parser->parse($line));
        }

        return (string)$result->getMagnitude();
    }
}
