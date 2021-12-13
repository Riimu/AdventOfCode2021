<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day12;

class Day12PartOne extends AbstractDay12Task
{
    protected static string $taskName = 'Day 12: Passage Pathing';

    protected function isValidPath(string $connection, array $path, array $big): bool
    {
        return $big[$connection] || $connection === 'end' || !\in_array($connection, $path, true);
    }
}
