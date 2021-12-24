<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day23;

use Riimu\AdventOfCode2021\Typed\Regex;

class Day23PartOne extends AbstractDay23Task
{
    protected static string $finalState = '...........AABBCCDD';
    protected static int $homeSize = 2;

    /** @var array<string, array<int, int>> */
    protected static array $homes = [
        'A' => [11, 12],
        'B' => [13, 14],
        'C' => [15, 16],
        'D' => [17, 18],
    ];

    /** @var array<int, int> */
    protected static array $entrances = [11 => 2, 2, 4, 4, 6, 6, 8, 8];

    /** @var array<string, array<int, int>> */
    protected static array $stepCount = [
        'A' => [3, 2, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 0, 4, 5, 6, 7, 8, 9],
        'B' => [5, 4, 3, 2, 1, 2, 3, 4, 5, 6, 7, 4, 5, 0, 0, 4, 5, 6, 7],
        'C' => [7, 6, 5, 4, 3, 2, 1, 2, 3, 4, 5, 6, 7, 4, 5, 0, 0, 4, 5],
        'D' => [9, 8, 7, 6, 5, 4, 3, 2, 1, 2, 3, 8, 9, 6, 7, 4, 5, 0, 0],
    ];

    protected static string $taskName = 'Day 23: Amphipod';

    public function run(): string
    {
        $input = Regex::replace('/\s+/', '', $this->getInput('day-23.txt'));
        $state = substr($input, 14, 11);
        $state .= $input[29] . $input[40] . $input[31] . $input[42] . $input[33] . $input[44] . $input[35] . $input[46];

        return (string)$this->solveState($state);
    }
}
