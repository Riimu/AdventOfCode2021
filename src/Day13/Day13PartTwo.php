<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day13;

use Riimu\AdventOfCode2021\Typed\Regex;

class Day13PartTwo extends AbstractDay13Task
{
    protected static string $taskName = 'Day 13: Transparent Origami (Part Two)';

    public function run(): string
    {
        [$coordinateInput, $foldInput] = Regex::split('/\R\R/', $this->getInput('day-13.txt'));

        $map = $this->parseMap($coordinateInput);

        foreach (Regex::split('/\R/', $foldInput) as $line) {
            $map = $this->fold($map, $line);
        }

        $output = [];

        foreach ($map as $row) {
            $line = array_fill(0, \count($row), '.');

            foreach ($row as $x => $value) {
                if ($value) {
                    $line[$x] = '#';
                }
            }

            $output[] = implode('', $line);
        }

        return implode("\n", $output);
    }
}
