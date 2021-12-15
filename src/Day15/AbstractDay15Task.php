<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day15;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;
use Riimu\AdventOfCode2021\Typed\Regex;

abstract class AbstractDay15Task extends AbstractTask
{
    protected function solveMap(array $map): int
    {
        $lastX = \count(Arrays::last($map)) - 1;
        $lastY = \count($map) - 1;

        $nodes = new class extends \SplPriorityQueue {
            public function compare(mixed $priority1, mixed $priority2): int
            {
                return $priority2 <=> $priority1;
            }
        };

        $visited = [];
        $nodes->insert([0, 0, 0], $lastX + $lastY);

        while (!$nodes->isEmpty()) {
            [$x, $y, $cost] = $nodes->extract();

            if (isset($visited[$y][$x])) {
                continue;
            }

            if ($x === $lastX && $y === $lastY) {
                return $cost;
            }

            $visited[$y][$x] = true;
            $neighbors = [
                [$x - 1, $y],
                [$x + 1, $y],
                [$x, $y - 1],
                [$x, $y + 1],
            ];

            foreach ($neighbors as [$x, $y]) {
                if (!isset($map[$y][$x])) {
                    continue;
                }

                $newCost = $cost + $map[$y][$x];
                $heuristic = $newCost + abs($lastX - $x) + abs($lastY - $y);

                $nodes->insert([$x, $y, $newCost], $heuristic);
            }
        }

        throw new \RuntimeException('Could not find any path to goal');
    }
}
