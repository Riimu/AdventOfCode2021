<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day15;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;

class Day15PartOne extends AbstractTask
{
    protected static string $taskName = 'Day 15: Chiton';

    public function run(): string
    {
        $map = [];

        foreach ($this->getInputLines('day-15.txt') as $line) {
            $row = array_map(
                fn(string $value): int => Integers::parse($value),
                str_split($line)
            );

            $map[] = $row;
        }

        $lastX = \count(Arrays::last($map)) - 1;
        $lastY = \count($map) - 1;

        $h = fn($point) => abs($lastX - $point[0]) + abs($lastY - $point[1]);
        $d = fn($neighbor, $map) => $map[$neighbor[1]][$neighbor[0]];
        $lowest = function ($openSet, $fScore) {
            [$lowX, $lowY] = Arrays::first($openSet);

            foreach ($openSet as [$x, $y]) {
                if ($fScore[$y][$x] < $fScore[$lowY][$lowX]) {
                    $lowX = $x;
                    $lowY = $y;
                }
            }

            return [$lowX, $lowY];
        };

        $openSet = [[0, 0]];

        $gScore = [];
        $gScore[0][0] = 0;

        $fScore = [];
        $fScore[0][0] = $h([0, 0]);

        while ($openSet !== []) {
            [$x, $y] = $lowest($openSet, $fScore);

            if ($x === $lastX && $y === $lastY) {
                return (string)$gScore[$y][$x];
            }

            unset($openSet[array_search([$x, $y], $openSet, true)]);

            $neighbors = [
                [$x - 1, $y],
                [$x + 1, $y],
                [$x, $y - 1],
                [$x, $y + 1],
            ];

            foreach ($neighbors as [$neighborX, $neighborY]) {
                if (!isset($map[$neighborY][$neighborX])) {
                    continue;
                }

                $tentativeScore = $gScore[$y][$x] + $d([$neighborX, $neighborY], $map);

                if (!isset($gScore[$neighborY][$neighborX]) || $tentativeScore < $gScore[$neighborY][$neighborX]) {
                    $gScore[$neighborY][$neighborX] = $tentativeScore;
                    $fScore[$neighborY][$neighborX] = $tentativeScore + $h([$neighborX, $neighborY]);

                    if (!\in_array([$neighborX, $neighborY], $openSet, true)) {
                        $openSet[] = [$neighborX, $neighborY];
                    }
                }
            }
        }

        throw new \RuntimeException('Could not find any path to goal');
    }


}
