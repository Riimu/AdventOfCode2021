<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day23;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;

class Day23PartOne extends AbstractTask
{
    private const FINAL_STATE = '...........AABBCCDD';

    private const HOMES = [
        'A' => [11, 12],
        'B' => [13, 14],
        'C' => [15, 16],
        'D' => [17, 18],
    ];

    private const HALLWAYS = [0, 1, 3, 5, 7, 9, 10];

    private const ENTRANCES = [
        11 => 2,
        12 => 2,
        13 => 4,
        14 => 4,
        15 => 6,
        16 => 6,
        17 => 8,
        18 => 8,
    ];

    private const STEP_COUNT = [
        'A' => [3, 2, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 0, 4, 5, 6, 7, 8, 9],
        'B' => [5, 4, 3, 2, 1, 2, 3, 4, 5, 6, 7, 4, 5, 0, 0, 4, 5, 6, 7],
        'C' => [7, 6, 5, 4, 3, 2, 1, 2, 3, 4, 5, 6, 7, 4, 5, 0, 0, 4, 5],
        'D' => [9, 8, 7, 6, 5, 4, 3, 2, 1, 2, 3, 8, 9, 6, 7, 4, 5, 0, 0],
    ];

    private const STEP_COST = [
        'A' => 1,
        'B' => 10,
        'C' => 100,
        'D' => 1000,
    ];

    protected static string $taskName = 'Day 23: Amphipod';

    public function run(): string
    {
        $input = preg_replace('/\s+/', '', $this->getInput('day-23.txt'));
        $state = substr($input, 14, 11);
        $state .= $input[29] . $input[40] . $input[31] . $input[42] . $input[33] . $input[44] . $input[35] . $input[46];

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
        if ($position === self::HOMES[$type][1]) {
            return true;
        }

        return $state[self::HOMES[$type][1]] === $type && $position === self::HOMES[$type][0];
    }

    private function getFreeHome(string $state, string $type): int
    {
        if ($state[self::HOMES[$type][0]] !== '.') {
            return -1;
        }

        if ($state[self::HOMES[$type][1]] === '.') {
            return self::HOMES[$type][1];
        }

        if ($state[self::HOMES[$type][1]] === $type) {
            return self::HOMES[$type][0];
        }

        return -1;
    }

    private function isAtHallway(int $position): bool
    {
        return \in_array($position, self::HALLWAYS, true);
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
            $path[] = $from;

            if ($from % 2 === 0) {
                $path[] = $from - 1;
            }

            $fromHallway = self::ENTRANCES[$from];
        }

        $toHallway = $this->isAtHallway($to) ? $to : self::ENTRANCES[$to];
        array_push($path, ... range($fromHallway, $toHallway));

        if (!$this->isAtHallway($to)) {
            if ($to % 2 === 0) {
                $path[] = $to - 1;
            }

            $path[] = $to;
        }

        return array_slice($path, 1);
    }
}
