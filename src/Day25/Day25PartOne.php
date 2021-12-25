<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day25;

use Riimu\AdventOfCode2021\AbstractTask;

class Day25PartOne extends AbstractTask
{
    protected static string $taskName = 'Day 25: Sea Cucumber';

    public function run(): string
    {
        $map = [];

        foreach ($this->getInputLines('day-25.txt') as $line) {
            $map[] = str_split($line);
        }

        $step = 0;

        do {
            $step++;
            $moved = 0;

            $map = $this->moveEast($map, $moved);
            $map = $this->moveSouth($map, $moved);
        } while ($moved > 0);

        return (string)$step;
    }

    /**
     * @param array<int, array<int, string>> $map
     * @param int $moved
     * @return array<int, array<int, string>>
     */
    private function moveEast(array $map, int &$moved): array
    {
        $newMap = $map;

        foreach ($map as $y => $row) {
            $width = \count($row);

            foreach ($row as $x => $space) {
                if ($space === '>' && $row[($x + 1) % $width] === '.') {
                    $newMap[$y][$x] = '.';
                    $newMap[$y][($x + 1) % $width] = '>';
                    $moved++;
                }
            }
        }

        return $newMap;
    }

    /**
     * @param array<int, array<int, string>> $map
     * @param int $moved
     * @return array<int, array<int, string>>
     */
    private function moveSouth(array $map, int &$moved): array
    {
        $newMap = $map;
        $height = \count($map);

        foreach ($map as $y => $row) {
            foreach ($row as $x => $space) {
                if ($space === 'v' && $map[($y + 1) % $height][$x] === '.') {
                    $newMap[$y][$x] = '.';
                    $newMap[($y + 1) % $height][$x] = 'v';
                    $moved++;
                }
            }
        }

        return $newMap;
    }
}
