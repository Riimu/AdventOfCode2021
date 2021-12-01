<?php

namespace Riimu\AdventOfCode2021\Day1;

use Riimu\AdventOfCode2021\TaskInterface;

class Day1PartTwo implements TaskInterface
{
    public function run(): string
    {
        $lines = preg_split('/\R/', file_get_contents(__DIR__ . '/input.txt'));
        $total = 0;
        $windows = [];

        foreach ($lines as $number => $line) {
            $depth = (int)$line;

            for ($i = 0; $i < 3; $i++) {
                if (!isset($windows[$number + $i])) {
                    $windows[$number + $i] = 0;
                }

                $windows[$number + $i] += $depth;
            }

            if ($number > 3 && $windows[$number - 2] > $windows[$number - 3]) {
                $total++;
            }
        }

        return (string)$total;
    }
}
