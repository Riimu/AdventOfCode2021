<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day14;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Integers;
use Riimu\AdventOfCode2021\Typed\Regex;

class Day14PartOne extends AbstractTask
{
    protected static string $taskName = 'Day 14: Extended Polymerization';

    public function run(): string
    {
        [$polymer, $ruleInput] = Regex::split('/\R\R/', $this->getInput('day-14.txt'));

        $rules = [];

        foreach (Regex::split('/\R/', $ruleInput) as $line) {
            $rules[$line[0]][$line[1]] = $line[6];
        }

        $characters = implode('', array_keys($rules));

        for ($i = 0; $i < 10; $i++) {
            $newPolymer = [];

            while (true) {
                $last = strpbrk($polymer, $characters);

                if ($last === false || \strlen($polymer) === 1) {
                    $newPolymer[] = $polymer;
                    break;
                }

                $offset = \strlen($polymer) - \strlen($last);

                if ($offset !== 0) {
                    $newPolymer[] = substr($polymer, 0, $offset);
                }

                $newPolymer[] = $last[0];

                if (isset($rules[$last[0]][$last[1]])) {
                    $newPolymer[] = $rules[$last[0]][$last[1]];
                }

                $polymer = substr($last, 1);
            }

            $polymer = implode('', $newPolymer);
        }

        $counts = array_count_values(str_split($polymer));

        return (string)(max($counts) - min($counts));
    }
}
