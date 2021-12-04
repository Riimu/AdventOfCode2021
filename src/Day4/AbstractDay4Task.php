<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day4;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Regex;

abstract class AbstractDay4Task extends AbstractTask
{
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

        return $this->calculateScore($numbers, $boards, $winners);
    }

    /**
     * @param array<int> $numbers
     * @param array<int, array<int>> $boards
     * @param array<int, array<int>> $winners
     * @return string
     */
    abstract protected function calculateScore(array $numbers, array $boards, array $winners): string;

    protected function parseBoardNumbers(string $board): array
    {
        $numbers = [];
        $lines = Regex::split('/\R/', $board);

        foreach ($lines as $line) {
            array_push($numbers, ... Regex::split('/\s+/', trim($line)));
        }

        return array_map(fn (string $number) => $this->parseInt($number), $numbers);
    }

    protected function getWinners(array $board): array
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
