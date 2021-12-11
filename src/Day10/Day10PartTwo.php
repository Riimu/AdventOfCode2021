<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day10;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;

class Day10PartTwo extends AbstractTask
{
    private const CHUNKS = [
        ')' => '(',
        ']' => '[',
        '}' => '{',
        '>' => '<',
    ];

    private const SCORE = [
        '(' => 1,
        '[' => 2,
        '{' => 3,
        '<' => 4,
    ];

    protected static string $taskName = 'Day 10: Syntax Scoring (Part Two)';

    public function run(): string
    {
        $scores = [];

        foreach ($this->getInputLines('day-10.txt') as $line) {
            $stack = [];

            foreach (str_split($line) as $character) {
                if (\in_array($character, self::CHUNKS, true)) {
                    $stack[] = $character;
                    continue;
                }

                if (Arrays::last($stack) !== self::CHUNKS[$character]) {
                    continue 2;
                }

                array_pop($stack);
            }

            $points = 0;

            foreach (array_reverse($stack) as $character) {
                $points = $points * 5 + self::SCORE[$character];
            }

            $scores[] = $points;
        }

        sort($scores);

        return (string)$scores[intdiv(\count($scores), 2)];
    }
}
