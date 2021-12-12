<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day12;

class Day12PartTwo extends AbstractDay12Task
{
    protected static string $taskName = 'Day 12: Passage Pathing (Part Two)';

    protected function isValidPath(string $connection, array $path, array $big): bool
    {
        if ($big[$connection] || $connection === 'end' || !\in_array($connection, $path, true)) {
            return true;
        }

        $visited = [];

        foreach ($path as $cave) {
            if ($big[$cave]) {
                continue;
            }

            if (\array_key_exists($cave, $visited)) {
                return false;
            }

            $visited[$cave] = true;
        }

        return true;
    }
}
