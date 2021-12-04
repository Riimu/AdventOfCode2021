<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day4;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Regex;

class Day4PartOne extends AbstractTask
{
    protected static string $taskName = 'Day 4: Giant Squid';

    public function run(): string
    {
        $input = $this->getInput('day-4.txt');
        $boards = Regex::split('/\R\R/', $input);
        $numbers = array_map(
            fn (string $number) => $this->parseInt($number),
            Regex::split('/,/', array_shift($boards))
        );
        $boards = array_map(fn (string $board) => $this->parseBoardNumbers($board), $boards);
        $winners = array_merge(... array_map(fn (array $board) => $this->getWinners($board), $boards));

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

    private function parseBoardNumbers(string $board): array
    {
        $numbers = [];
        $lines = Regex::split('/\R/', $board);

        foreach ($lines as $line) {
            array_push($numbers, ... Regex::split('/\s+/', trim($line)));
        }

        return array_map(fn (string $number) => $this->parseInt($number), $numbers);
    }

    private function getWinners(array $board): array
    {
        $winners = [];

        for ($i = 0; $i < 5; $i++) {
            for ($j = 0; $j < 5; $j++) {
                $winners[$i][] = $board[$i * 5 + $j];
                $winners[$i + 5][] = $board[$j * 5 + $i];
            }
        }

        return $winners;
    }
}
