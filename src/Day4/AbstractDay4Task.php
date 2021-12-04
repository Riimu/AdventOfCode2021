<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day4;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;
use Riimu\AdventOfCode2021\Typed\Regex;

abstract class AbstractDay4Task extends AbstractTask
{
    public function run(): string
    {
        $inputs = Regex::split('/\R\R/', $this->getInput('day-4.txt'));
        $numbers = array_map(
            fn (string $number) => Integers::parse($number),
            Regex::split('/,/', Arrays::shift($inputs))
        );
        $boards = array_map(fn (string $board) => $this->parseBoardNumbers($board), array_values($inputs));
        $winners = array_merge(... array_map(fn (array $board) => $this->getWinners($board), $boards));

        return $this->calculateScore($numbers, $boards, $winners);
    }

    /**
     * @param array<int, int> $numbers
     * @param array<int, array<int, int>> $boards
     * @param array<int, array<int, int>> $winners
     * @return string
     */
    abstract protected function calculateScore(array $numbers, array $boards, array $winners): string;

    /**
     * @param string $board
     * @return array<int, int>
     */
    protected function parseBoardNumbers(string $board): array
    {
        $numbers = [];
        $lines = Regex::split('/\R/', $board);

        foreach ($lines as $line) {
            array_push($numbers, ... Regex::split('/\s+/', trim($line)));
        }

        return array_map(fn (string $number) => Integers::parse($number), $numbers);
    }

    /**
     * @param array<int, int> $board
     * @return array<int, array<int, int>>
     */
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
