<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day24;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Integers;

class Day24PartOne extends AbstractTask
{
    protected static string $taskName = 'Day 24: Arithmetic Logic Unit';

    public function run(): string
    {
        $compiler = new MonadCompiler();
        $runner = $compiler->compile($this->getInputLines('day-24.txt'));

        $number = '11111111111111';
        $total = \strlen($number);
        $locked = array_fill(0, $total, false);
        $verify = -1;

        while (true) {
            $verify = $this->nextUnlocked($locked, $verify);

            if ($verify === -1) {
                break;
            }

            $fails = $this->countFails($runner, $number);

            for ($i = 2; $i <= 9; $i++) {
                $number[$verify] = (string)$i;

                if ($this->countFails($runner, $number) < $fails) {
                    $locked[$verify] = true;
                    $pair = -1;

                    while (true) {
                        $pair = $this->nextUnlocked($locked, $pair);

                        for ($j = 2; $j <= 9; $j++) {
                            $number[$pair] = (string)$j;

                            if ($this->countFails($runner, $number) === $fails) {
                                $locked[$pair] = true;
                                $number[$verify] = 9;
                                $number[$pair] = 9 - ($i - 1);
                                $verify = -1;
                                continue 4;
                            }
                        }

                        $number[$pair] = '1';
                    }
                }
            }

            $number[$verify] = '1';
        }

        return $number;
    }

    public function countFails(AluRunner $runner, string $number): int
    {
        $result = $runner->calculate(array_map(
            fn (string $digit): int => Integers::parse($digit),
            str_split($number)
        ));

        $checks = 0;

        while ($result > 0) {
            $checks++;
            $result = intdiv($result, 26);
        }

        return $checks;
    }

    private function nextUnlocked(array $locks, int $offset): int {
        for ($i = max(0, $offset + 1); $i < \count($locks); $i++) {
            if ($locks[$i] === false) {
                return $i;
            }
        }

        return -1;
    }
}
