<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day14;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Integers;
use Riimu\AdventOfCode2021\Typed\Regex;

class Day14PartTwo extends AbstractTask
{
    protected static string $taskName = 'Day 14: Extended Polymerization (Part Two)';

    public function run(): string
    {
        [$polymer, $ruleInput] = Regex::split('/\R\R/', $this->getInput('day-14.txt'));

        $pairs = [];
        $rules = [];

        for ($i = \strlen($polymer) - 1; $i > 0; $i--) {
            $pairs[$polymer[$i - 1] . $polymer[$i]] ??= 0;
            $pairs[$polymer[$i - 1] . $polymer[$i]]++;
        }

        foreach (Regex::split('/\R/', $ruleInput) as $line) {
            $rules[$line[0] . $line[1]] = [
                $line[0] . $line[6],
                $line[6] . $line[1],
            ];
        }

        for ($i = 0; $i < 40; $i++) {
            $newPairs = [];

            foreach (array_intersect_key($rules, $pairs) as $pair => $replacements) {
                foreach ($replacements as $new) {
                    $newPairs[$new] ??= 0;
                    $newPairs[$new] += $pairs[$pair];
                }

                unset($pairs[$pair]);
            }

            foreach ($pairs as $pair => $count) {
                $newPairs[$pair] ??= 0;
                $newPairs[$pair] += $count;
            }

            $pairs = $newPairs;
        }

        $counts = [$polymer[-1] => 1];

        foreach ($pairs as $pair => $count) {
            $counts[$pair[0]] ??= 0;
            $counts[$pair[0]] += $count;
        }

        return (string)(max($counts) - min($counts));
    }
}
