<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day4;

use Riimu\AdventOfCode2021\Typed\Arrays;

class Day4PartOne extends AbstractDay4Task
{
    protected static string $taskName = 'Day 4: Giant Squid';

    protected function calculateScore(array $numbers, array $boards, array $winners): string
    {
        $count = 4;

        do {
            $count++;
            $picked = \array_slice($numbers, 0, $count);
            $winningBoards = array_filter($winners, fn (array $line) => array_diff($line, $picked) === []);
        } while ($winningBoards === []);

        $winner = $boards[intdiv(array_key_first($winningBoards), 10)];
        $unselectedSum = array_sum(array_diff($winner, $picked));

        return (string)($unselectedSum * Arrays::last($picked));
    }
}
