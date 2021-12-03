<?php

namespace Riimu\AdventOfCode2021\Day3;

use Riimu\AdventOfCode2021\AbstractTask;

abstract class AbstractDay3Class extends AbstractTask
{
    /**
     * @param iterable<string> $strings
     * @param int $position
     * @param string $character
     * @return int
     */
    protected function countPositionCharacter(iterable $strings, int $position, string $character): int
    {
        $count = 0;

        foreach ($strings as $string) {
            if ($string[$position] === $character) {
                $count++;
            }
        }

        return $count;
    }
}
