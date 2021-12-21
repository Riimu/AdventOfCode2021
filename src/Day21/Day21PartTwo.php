<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day21;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;
use Riimu\AdventOfCode2021\Typed\Regex;

class Day21PartTwo extends AbstractTask
{
    protected static string $taskName = 'Day 21: Dirac Dice (Part Two)';

    public function run(): string
    {
        $players = [];

        foreach ($this->getInputLines('day-21.txt') as $line) {
            $players[] = Integers::parse(Regex::split('/\s*:\s*/', $line)[1]) - 1;
        }

        $possibilities = [];

        foreach (range(1, 3) as $i) {
            foreach (range(1, 3) as $j) {
                foreach (range(1, 3) as $k) {
                    $total = $i + $j + $k;

                    $possibilities[$total] ??= 0;
                    $possibilities[$total]++;
                }
            }
        }

        $wins = [];
        $key = [];

        foreach ($players as $player => $position) {
            $wins[$player] = 0;
            $key[] = $position;
            $key[] = 0;
        }

        $realities = [implode('-', $key) => 1];
        $current = 0;
        $playerCount = \count($players);

        while (\count($realities) > 0) {
            $newRealities = [];

            foreach ($realities as $stateKey => $count) {
                $state = array_map(fn ($value) => Integers::parse($value), explode('-', $stateKey));

                foreach ($possibilities as $result => $splits) {
                    $newState = $state;
                    $newState[$current * 2] = ($newState[$current * 2] + $result) % 10;
                    $newState[$current * 2 + 1] += $newState[$current * 2] + 1;

                    if ($newState[$current * 2 + 1] >= 21) {
                        $wins[$current] += $count * $splits;
                        continue;
                    }

                    $newRealities[implode('-', $newState)] ??= 0;
                    $newRealities[implode('-', $newState)] += $count * $splits;
                }
            }

            $realities = $newRealities;
            $current = ($current + 1) % $playerCount;
        }

        return (string)(Arrays::max($wins));
    }
}
