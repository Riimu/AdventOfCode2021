<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day24;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;

abstract class AbstractDay24Task extends AbstractTask
{
    public function findSerial(bool $max): string
    {
        $compiler = new MonadCompiler();
        $runner = $compiler->compile($this->getInputLines('day-24.txt'));

        $number = '11111111111111';
        $total = \strlen($number);
        $locked = array_fill(0, $total, false);

        while ($this->countFails($runner, $number) < intdiv(Arrays::countRecursive($locked, false), 2)) {
            $fails = $this->countFails($runner, $number);
            $verify = $this->findKeyDigit($runner, $number, $locked, $fails + 1);
            $number[$verify] = '1';
            $locked[$verify] = true;

            $pair = $this->findKeyDigit($runner, $number, $locked, $fails + 1);
            $locked[$pair] = true;

            $number[$verify] = $max ? '9' : '1';
            $number[$pair] = $max ? '9' : '1';
        }

        while (true) {
            $fails = $this->countFails($runner, $number);
            $verify = $this->findKeyDigit($runner, $number, $locked, $fails - 1);

            if ($verify === -1) {
                break;
            }

            $locked[$verify] = true;
            $pair = $this->findKeyDigit($runner, $number, $locked, $fails);
            $locked[$pair] = true;

            $min = Integers::parse($number[$verify]);
            $number[$verify] = $max ? 9 : $min;
            $number[$pair] = $max ? 9 - ($min - 1) : 1;
        }

        return $number;
    }

    /**
     * @param AluRunner $runner
     * @param string $number
     * @param array<int, bool> $locked
     * @param int $expectedFails
     * @return int
     */
    private function findKeyDigit(AluRunner $runner, string &$number, array $locked, int $expectedFails): int
    {
        $key = -1;

        while (true) {
            $key = $this->nextUnlocked($locked, $key);

            if ($key === -1) {
                return -1;
            }

            for ($i = 2; $i <= 9; $i++) {
                $number[$key] = (string)$i;

                if ($this->countFails($runner, $number) === $expectedFails) {
                    return $key;
                }
            }

            $number[$key] = '1';
        }
    }

    private function countFails(AluRunner $runner, string $number): int
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

    /**
     * @param array<int, bool> $locks
     * @param int $offset
     * @return int
     */
    private function nextUnlocked(array $locks, int $offset): int
    {
        for ($i = max(0, $offset + 1); $i < \count($locks); $i++) {
            if ($locks[$i] === false) {
                return $i;
            }
        }

        return -1;
    }
}
