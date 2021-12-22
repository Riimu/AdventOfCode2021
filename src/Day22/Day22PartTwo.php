<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day22;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;

class Day22PartTwo extends AbstractTask
{
    protected static string $taskName = 'Day 22: Reactor Reboot (Part Two)';

    public function run(): string
    {
        $cubes = [];

        foreach ($this->getInputLines('day-22.txt') as $line) {
            $turnOn = str_starts_with($line, 'on');
            $cube = Integers::parseAll($line);

            $cube[1]++;
            $cube[3]++;
            $cube[5]++;

            if (\count($cubes) === 0) {
                if ($turnOn) {
                    $cubes[] = $cube;
                }

                continue;
            }

            $cubes = $turnOn
                ? $this->addCube($cube, $cubes)
                : $this->removeCube($cube, $cubes);
        }

        return (string)array_sum(array_map(
            fn (array $cube): int => $this->calculateSize($cube),
            $cubes
        ));
    }

    private function addCube(array $cube, array $cubes): array
    {
        foreach ($cubes as $key => $existingCube) {
            if ($this->cubeContains($cube, $existingCube)) {
                unset($cubes[$key]);
            } elseif ($this->cubeContains($existingCube, $cube)) {
                return $cubes;
            }
        }

        $newCubes = [$cube];

        foreach ($cubes as $existingCube) {
            $broken = [];

            foreach ($newCubes as $new) {
                array_push($broken, ...$this->breakCube($new, $existingCube));
            }

            $newCubes = $broken;
        }

        return [...$cubes, ...$newCubes];
    }

    private function removeCube(array $cube, array $cubes): array
    {
        $newCubes = [];

        foreach ($cubes as $existingCube) {
            array_push($newCubes, ... $this->breakCube($existingCube, $cube));
        }

        return $newCubes;
    }

    private function cubeContains(array $cube, array $other): bool
    {
        return $other[0] >= $cube[0]
            && $other[1] <= $cube[1]
            && $other[2] >= $cube[2]
            && $other[3] <= $cube[3]
            && $other[4] >= $cube[4]
            && $other[5] <= $cube[5];
    }

    private function breakCube(array $cube, array $exclude): array
    {
        if (
            $cube[0] >= $exclude[1] ||
            $cube[1] <= $exclude[0] ||
            $cube[2] >= $exclude[3] ||
            $cube[3] <= $exclude[2] ||
            $cube[4] >= $exclude[5] ||
            $cube[5] <= $exclude[4]
        ) {
            return [$cube];
        }

        if ($this->cubeContains($exclude, $cube)) {
            return [];
        }

        $newCubes = [];

        if ($cube[0] < $exclude[0]) {
            $newCubes[] = [$cube[0], $exclude[0], $cube[2], $cube[3], $cube[4], $cube[5]];
        }
        if ($cube[1] > $exclude[1]) {
            $newCubes[] = [$exclude[1], $cube[1], $cube[2], $cube[3], $cube[4], $cube[5]];
        }

        $minX = max($cube[0], $exclude[0]);
        $maxX = min($cube[1], $exclude[1]);

        if ($cube[2] < $exclude[2]) {
            $newCubes[] = [$minX, $maxX, $cube[2], $exclude[2], $cube[4], $cube[5]];
        }
        if ($cube[3] > $exclude[3]) {
            $newCubes[] = [$minX, $maxX, $exclude[3], $cube[3], $cube[4], $cube[5]];
        }

        $minY = max($cube[2], $exclude[2]);
        $maxY = min($cube[3], $exclude[3]);

        if ($cube[4] < $exclude[4]) {
            $newCubes[] = [$minX, $maxX, $minY, $maxY, $cube[4], $exclude[4]];
        }
        if ($cube[5] > $exclude[5]) {
            $newCubes[] = [$minX, $maxX, $minY, $maxY, $exclude[5], $cube[5]];
        }

        return $newCubes;
    }

    private function calculateSize(array $cube): int
    {
        return ($cube[1] - $cube[0]) * ($cube[3] - $cube[2]) * ($cube[5] - $cube[4]);
    }
}
