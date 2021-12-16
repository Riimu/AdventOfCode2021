<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day16;

class Day16PartTwo extends AbstractDay16Task
{
    protected static string $taskName = 'Day 16: Packet Decoder (Part Two)';

    protected function calculateResult(Packet $packet): int
    {
        return $packet->calculate();
    }
}
