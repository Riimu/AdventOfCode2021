<?php

namespace Riimu\AdventOfCode2021\Day1;

use Riimu\AdventOfCode2021\TaskInterface;

class Day1PartOne implements TaskInterface
{
    public function run(): string
    {
        $lines = preg_split('/\R/', file_get_contents(__DIR__ . '/input.txt'));
        $previous = null;
        $total = 0;

        foreach ($lines as $line) {
            $depth = (int)$line;

            if ($previous !== null && $depth > $previous) {
                $total++;
            }

            $previous = $depth;
        }

        return (string)$total;
    }
}
