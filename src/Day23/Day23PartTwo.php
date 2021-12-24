<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day23;

use Riimu\AdventOfCode2021\Typed\Regex;

class Day23PartTwo extends AbstractDay23Task
{
    protected static string $finalState = '...........AAAABBBBCCCCDDDD';
    protected static int $homeSize = 4;

    /** @var array<string, array<int, int>> */
    protected static array $homes = [
        'A' => [11, 12, 13, 14],
        'B' => [15, 16, 17, 18],
        'C' => [19, 20, 21, 22],
        'D' => [23, 24, 25, 26],
    ];

    /** @var array<int, int> */
    protected static array $entrances = [11 => 2, 2, 2, 2, 4, 4, 4, 4, 6, 6, 6, 6, 8, 8, 8, 8];

    /** @var array<string, array<int, int>> */
    protected static array $stepCount = [
        'A' => [3, 2, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 0, 0, 0, 4, 5, 6, 7, 6, 7, 8, 9, 8, 9, 10, 11],
        'B' => [5, 4, 3, 2, 1, 2, 3, 4, 5, 6, 7, 4, 5, 6, 7, 0, 0, 0, 0, 4, 5, 6, 7, 6, 7, 8, 9],
        'C' => [7, 6, 5, 4, 3, 2, 1, 2, 3, 4, 5, 6, 7, 8, 9, 4, 5, 6, 7, 0, 0, 0, 0, 4, 5, 6, 7],
        'D' => [9, 8, 7, 6, 5, 4, 3, 2, 1, 2, 3, 8, 9, 10, 11, 6, 7, 8, 9, 4, 5, 6, 7, 0, 0, 0, 0],
    ];

    protected static string $taskName = 'Day 23: Amphipod (Part Two)';

    public function run(): string
    {
        $input = Regex::replace('/\s+/', '', $this->getInput('day-23.txt'));
        $state = substr($input, 14, 11);
        $state .=
            $input[29] . 'DD' . $input[40] .
            $input[31] . 'CB' . $input[42] .
            $input[33] . 'BA' . $input[44] .
            $input[35] . 'AC' . $input[46];

        return (string)$this->solveState($state);
    }
}
