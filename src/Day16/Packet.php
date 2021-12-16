<?php

namespace Riimu\AdventOfCode2021\Day16;

class Packet
{
    public readonly array $packets;

    public function __construct(
        public readonly int $version,
        public readonly int $type,
        public readonly int $value,
        array $packets
    ) {
        $this->packets = (fn (Packet ...$packets): array => $packets)(... $packets);
    }

    public function calculate(): int
    {
        $values = array_map(fn (Packet $packet): int => $packet->calculate(), $this->packets);

        return match ($this->type) {
            0 => array_sum($values),
            1 => array_product($values),
            2 => min($values),
            3 => max($values),
            4 => $this->value,
            5 => $values[0] > $values[1] ? 1 : 0,
            6 => $values[0] < $values[1] ? 1 : 0,
            7 => $values[0] === $values[1] ? 1 : 0,
        };
    }
}
