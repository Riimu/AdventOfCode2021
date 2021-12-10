<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day10;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;

class Day10PartOne extends AbstractTask
{
    private const CHUNKS = [
        ')' => '(',
        ']' => '[',
        '}' => '{',
        '>' => '<',
    ];

    private const SCORE = [
        ')' => 3,
        ']' => 57,
        '}' => 1197,
        '>' => 25137,
    ];

    protected static string $taskName = 'Day 10: Syntax Scoring';

    public function run(): string
    {
        $score = 0;
        $stack = [];

        foreach ($this->getInputLines('day-10.txt') as $line) {
            foreach (str_split($line) as $character) {
                if (\in_array($character, self::CHUNKS, true)) {
                    $stack[] = $character;
                    continue;
                }

                if (Arrays::last($stack) !== self::CHUNKS[$character]) {
                    $score += self::SCORE[$character];
                    continue 2;
                }

                array_pop($stack);
            }
        }

        return (string)$score;
    }
}
