<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day16;

class Day16PartOne extends AbstractDay16Task
{
    protected static string $taskName = 'Day 16: Packet Decoder';

    protected function calculateResult(Packet $packet): int
    {
        return $packet->version + array_reduce(
            $packet->packets,
            fn (int $carry, Packet $packet): int => $carry + $this->calculateResult($packet),
            0
        );
    }
}
