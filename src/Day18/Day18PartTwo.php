<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day18;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;

class Day18PartTwo extends AbstractTask
{
    protected static string $taskName = 'Day 18: Snailfish (Part Two)';

    public function run(): string
    {
        $maximum = 0;
        $parser = new SnailfishParser();
        $lines = $this->getInputLines('day-18.txt');

        foreach ($lines as $first) {
            foreach ($lines as $second) {
                if ($first === $second) {
                    continue;
                }

                $firstResult = $parser->parse($first);
                $firstResult->add($parser->parse($second));

                $secondResult = $parser->parse($second);
                $secondResult->add($parser->parse($first));

                $maximum = max($maximum, $firstResult->getMagnitude(), $secondResult->getMagnitude());
            }
        }

        return (string)$maximum;
    }
}
