<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day13;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Integers;
use Riimu\AdventOfCode2021\Typed\Regex;

abstract class AbstractDay13Task extends AbstractTask
{
    /**
     * @param string $input
     * @return array<int, array<int, bool>>
     */
    protected function parseMap(string $input): array
    {
        $coords = [];
        $maxX = 0;
        $maxY = 0;

        foreach (Regex::split('/\R/', $input) as $line) {
            [$x, $y] = array_map(fn (string $value): int => Integers::parse($value), Regex::split('/,/', $line));

            $maxX = max($maxX, $x);
            $maxY = max($maxY, $y);
            $coords[] = [$x, $y];
        }

        $map = array_fill(0, $maxY + 1, array_fill(0, $maxX + 1, false));

        foreach ($coords as [$x, $y]) {
            $map[$y][$x] = true;
        }

        return $map;
    }

    /**
     * @param array<int, array<int, bool>> $map
     * @param string $input
     * @return array<int, array<int, bool>>
     */
    protected function fold(array $map, string $input): array
    {
        [$command, $value] = Regex::split('/=/', $input);
        $value = Integers::parse($value);

        if ($command === 'fold along x') {
            return $this->foldAlongX($map, $value);
        }

        return $this->foldAlongY($map, $value);
    }

    /**
     * @param array<int, array<int, bool>> $map
     * @param int $foldX
     * @return array<int, array<int, bool>>
     */
    protected function foldAlongX(array $map, int $foldX): array
    {
        foreach ($map as $y => $row) {
            $width = \count($row);

            for ($x = $foldX + 1; $x < $width; $x++) {
                if ($row[$x]) {
                    $row[$foldX - ($x - $foldX)] = true;
                }
            }

            $map[$y] = \array_slice($row, 0, $foldX);
        }

        return $map;
    }

    /**
     * @param array<int, array<int, bool>> $map
     * @param int $foldY
     * @return array<int, array<int, bool>>
     */
    protected function foldAlongY(array $map, int $foldY): array
    {
        $height = \count($map);

        for ($y = $foldY + 1; $y < $height; $y++) {
            foreach ($map[$y] as $x => $dot) {
                if ($dot) {
                    $map[$foldY - ($y - $foldY)][$x] = true;
                }
            }
        }

        return \array_slice($map, 0, $foldY);
    }
}
