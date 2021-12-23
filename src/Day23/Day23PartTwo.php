<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day23;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;

class Day23PartTwo extends AbstractTask
{
    private const FINAL_STATE = '...........AAAABBBBCCCCDDDD';

    private const HOME_SIZE = 4;

    private const HOMES = [
        'A' => [11, 12, 13, 14],
        'B' => [15, 16, 17, 18],
        'C' => [19, 20, 21, 22],
        'D' => [23, 24, 25, 26],
    ];

    private const HALLWAYS = [0, 1, 3, 5, 7, 9, 10];

    private const ENTRANCES = [11 => 2, 2, 2, 2, 4, 4, 4, 4, 6, 6, 6, 6, 8, 8, 8, 8];

    private const STEP_COUNT = [
        'A' => [3, 2, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 0, 0, 0, 4, 5, 6, 7, 6, 7, 8, 9, 8, 9, 10, 11],
        'B' => [5, 4, 3, 2, 1, 2, 3, 4, 5, 6, 7, 4, 5, 6, 7, 0, 0, 0, 0, 4, 5, 6, 7, 6, 7, 8, 9],
        'C' => [7, 6, 5, 4, 3, 2, 1, 2, 3, 4, 5, 6, 7, 8, 9, 4, 5, 6, 7, 0, 0, 0, 0, 4, 5, 6, 7],
        'D' => [9, 8, 7, 6, 5, 4, 3, 2, 1, 2, 3, 8, 9, 10, 11, 6, 7, 8, 9, 4, 5, 6, 7, 0, 0, 0, 0],
    ];

    private const STEP_COST = [
        'A' => 1,
        'B' => 10,
        'C' => 100,
        'D' => 1000,
    ];

    protected static string $taskName = 'Day 23: Amphipod (Part Two)';

    public function run(): string
    {
        $input = preg_replace('/\s+/', '', $this->getInput('day-23.txt'));
        $state = substr($input, 14, 11);
        $state .=
            $input[29] . 'DD' . $input[40] .
            $input[31] . 'CB' . $input[42] .
            $input[33] . 'BA' . $input[44] .
            $input[35] . 'AC' . $input[46];

        return (string)$this->solveState($state);
    }

    protected function solveState(string $initialState): int
    {
        $nodes = new class () extends \SplPriorityQueue {
            public function compare(mixed $priority1, mixed $priority2): int
            {
                return $priority2 <=> $priority1;
            }
        };

        $visited = [];
        $nodes->insert([$initialState, 0], $this->heurestic($initialState));

        while (!$nodes->isEmpty()) {
            $node = $nodes->extract();
            [$state, $cost] = $node;

            if (isset($visited[$state])) {
                continue;
            }

            if ($state === self::FINAL_STATE) {
                return $cost;
            }

            $visited[$state] = true;

            foreach ($this->neighbors($state) as [$neighbor, $distance]) {
                $newCost = $cost + $distance;
                $heuristic = $newCost + $this->heurestic($neighbor);

                $nodes->insert([$neighbor, $newCost], $heuristic);
            }
        }

        throw new \RuntimeException('Could not find any path to goal');
    }

    private function heurestic(string $state): int
    {
        $total = 0;
        $length = \strlen($state);

        for ($i = 0; $i < $length; $i++) {
            $type = $state[$i];

            if ($type === '.') {
                continue;
            }

            $total += self::STEP_COUNT[$type][$i] * self::STEP_COST[$type];
        }

        return $total;
    }

    private function neighbors(string $state): array
    {
        $neighbors = [];
        $length = \strlen($state);

        for ($i = 0; $i < $length; $i++) {
            $type = $state[$i];

            if ($type === '.' || $this->isAtHome($state, $type, $i)) {
                continue;
            }

            $freeHome = $this->getFreeHome($state, $type);
            $paths = [];

            if ($freeHome !== -1) {
                $paths[] = $this->getPath($i, $freeHome);
            }

            if (!$this->isAtHallway($i)) {
                foreach (self::HALLWAYS as $target) {
                    $paths[] = $this->getPath($i, $target);
                }
            }

            foreach ($paths as $path) {
                if (!$this->isFree($state, $path)) {
                    continue;
                }

                $neighbor = $state;
                $neighbor[$i] = '.';
                $neighbor[Arrays::last($path)] = $type;
                $neighbors[] = [$neighbor, self::STEP_COST[$type] * \count($path)];
            }
        }

        return $neighbors;
    }

    private function isAtHome(string $state, string $type, int $position): bool
    {
        $key = array_search($position, self::HOMES[$type], true);

        if ($key === false) {
            return false;
        }

        $count = \count(self::HOMES[$type]);

        for ($i = $key + 1; $i < $count; $i++) {
            if ($state[self::HOMES[$type][$i]] !== $type) {
                return false;
            }
        }

        return true;
    }

    private function getFreeHome(string $state, string $type): int
    {
        $freePosition = -1;

        foreach (self::HOMES[$type] as $position) {
            if ($state[$position] === '.') {
                $freePosition = $position;
            } elseif ($state[$position] !== $type) {
                return -1;
            }
        }

        return $freePosition;
    }

    private function isAtHallway(int $position): bool
    {
        return $position < 11;
    }

    private function isFree(string $state, array $path): bool
    {
        foreach ($path as $position) {
            if ($state[$position] !== '.') {
                return false;
            }
        }

        return true;
    }

    private function getPath(int $from, int $to): array
    {
        $path = [];
        $fromHallway = $from;

        if (!$this->isAtHallway($from)) {
            $firstHome = $from - ($from - 11) % self::HOME_SIZE;
            array_push($path, ... range($from, $firstHome));
            $fromHallway = self::ENTRANCES[$from];
        }

        $toHallway = $this->isAtHallway($to) ? $to : self::ENTRANCES[$to];
        array_push($path, ... range($fromHallway, $toHallway));

        if (!$this->isAtHallway($to)) {
            $firstHome = $to - ($to - 11) % self::HOME_SIZE;
            array_push($path, ... range($firstHome, $to));
        }

        return array_slice($path, 1);
    }
}
