<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day17;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Integers;

class Day17PartTwo extends AbstractTask
{
    protected static string $taskName = 'Day 17: Trick Shot (Part Two)';

    public function run(): string
    {
        $input = $this->getInput('day-17.txt');
        preg_match_all('/-?\d+/', $input, $matches);

        [$lowerX, $upperX, $lowerY, $upperY] = array_map(
            fn (string $value): int => Integers::parse($value),
            $matches[0]
        );

        $vertical = [];
        $horizontal = [];

        for ($i = $lowerY; $i < abs($lowerY); $i++) {
            $speed = $i;
            $height = 0;
            $steps = 0;

            do {
                $height += $speed;
                $speed--;
                $steps++;

                if ($height <= $upperY && $height >= $lowerY) {
                    $vertical[$steps][] = $i;
                }
            } while ($height > $lowerY);
        }

        $maxSteps = max(array_keys($vertical));

        for ($i = 1; $i <= $upperX; $i++) {
            $speed = $i;
            $length = 0;
            $steps = 0;

            do {
                $length += $speed;
                $speed = $speed > 0 ? $speed - 1 : 0;
                $steps++;

                if ($length >= $lowerX && $length <= $upperX) {
                    $horizontal[$steps][] = $i;
                }
            } while ($length < $upperX && $steps <= $maxSteps);
        }

        $speeds = [];

        foreach ($vertical as $steps => $options) {
            foreach ($horizontal[$steps] ?? [] as $horizontalSpeed) {
                foreach ($options as $verticalSpeed) {
                    $speeds["$horizontalSpeed,$verticalSpeed"] = true;
                }
            }
        }

        return (string)\count($speeds);
    }
}
