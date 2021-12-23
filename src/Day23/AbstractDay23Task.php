<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day23;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;

abstract class AbstractDay23Task extends AbstractTask
{
    private const HALLWAYS = [0, 1, 3, 5, 7, 9, 10];
    private const STEP_COST = [
        'A' => 1,
        'B' => 10,
        'C' => 100,
        'D' => 1000,
    ];

    protected static string $finalState;
    protected static int $homeSize;

    /** @var array<string, array<int, int>> */
    protected static array $homes;

    /** @var array<int, int> */
    protected static array $entrances;

    /** @var array<string, array<int, int>> */
    protected static array $stepCount;

    /** @psalm-suppress UnnecessaryVarAnnotation */
    protected function solveState(string $initialState): int
    {
        /** @var \SplPriorityQueue<int, array{string, int}> $nodes */
        $nodes = new class () extends \SplPriorityQueue {
            /**
             * @param int $priority1
             * @param int $priority2
             * @return int
             */
            public function compare(mixed $priority1, mixed $priority2): int
            {
                return $priority2 <=> $priority1;
            }
        };

        $visited = [];
        $nodes->insert([$initialState, 0], $this->heurestic($initialState));

        while (!$nodes->isEmpty()) {
            /** @var array{string, int} $node */
            $node = $nodes->extract();
            [$state, $cost] = $node;

            if (isset($visited[$state])) {
                continue;
            }

            if ($state === static::$finalState) {
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

            $total += static::$stepCount[$type][$i] * self::STEP_COST[$type];
        }

        return $total;
    }

    /**
     * @param string $state
     * @return array<int, array{string, int}>
     */
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
        $key = array_search($position, static::$homes[$type], true);

        if ($key === false) {
            return false;
        }

        $count = \count(static::$homes[$type]);

        for ($i = $key + 1; $i < $count; $i++) {
            if ($state[static::$homes[$type][$i]] !== $type) {
                return false;
            }
        }

        return true;
    }

    private function getFreeHome(string $state, string $type): int
    {
        $freePosition = -1;

        foreach (static::$homes[$type] as $position) {
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

    /**
     * @param string $state
     * @param array<int, int> $path
     * @return bool
     */
    private function isFree(string $state, array $path): bool
    {
        foreach ($path as $position) {
            if ($state[$position] !== '.') {
                return false;
            }
        }

        return true;
    }

    /**
     * @param int $from
     * @param int $to
     * @return array<int, int>
     */
    private function getPath(int $from, int $to): array
    {
        $path = [];
        $fromHallway = $from;

        if (!$this->isAtHallway($from)) {
            $firstHome = $from - ($from - 11) % static::$homeSize;
            array_push($path, ... Integers::range($from, $firstHome));
            $fromHallway = static::$entrances[$from];
        }

        $toHallway = $this->isAtHallway($to) ? $to : static::$entrances[$to];
        array_push($path, ... Integers::range($fromHallway, $toHallway));

        if (!$this->isAtHallway($to)) {
            $firstHome = $to - ($to - 11) % static::$homeSize;
            array_push($path, ... Integers::range($firstHome, $to));
        }

        return \array_slice($path, 1);
    }
}
