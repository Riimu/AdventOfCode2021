<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day12;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Regex;

abstract class AbstractDay12Task extends AbstractTask
{
    public function run(): string
    {
        $connections = [];
        $big = [];

        foreach ($this->getInputLines('day-12.txt') as $line) {
            [$start, $end] = Regex::split('/-/', $line);

            if ($start !== 'end' && $end !== 'start') {
                $connections[$start][] = $end;
            }

            if ($start !== 'start' && $end !== 'end') {
                $connections[$end][] = $start;
            }

            $big[$start] ??= strtoupper($start) === $start;
            $big[$end] ??= strtoupper($end) === $end;
        }

        $open = [['start']];
        $closed = [];

        while ($open !== []) {
            $path = array_pop($open);

            foreach ($connections[Arrays::last($path)] as $connection) {
                if ($this->isValidPath($connection, $path, $big)) {
                    $newPath = array_merge($path, [$connection]);

                    if ($connection === 'end') {
                        $closed[] = $newPath;
                        continue;
                    }

                    $open[] = $newPath;
                }
            }
        }

        return (string)\count($closed);
    }

    /**
     * @param string $connection
     * @param array<int, string> $path
     * @param array<string, bool> $big
     * @return bool
     */
    abstract protected function isValidPath(string $connection, array $path, array $big): bool;
}
