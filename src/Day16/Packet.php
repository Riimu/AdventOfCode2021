<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day16;

use Riimu\AdventOfCode2021\Typed\Arrays;

class Packet
{
    /** @var array<int, Packet> */
    public readonly array $packets;

    /**
     * @param int $version
     * @param int $type
     * @param int $value
     * @param array<int, Packet> $packets
     */
    public function __construct(
        public readonly int $version,
        public readonly int $type,
        public readonly int $value,
        array $packets
    ) {
        $this->packets = $packets;
    }

    public function calculate(): int
    {
        if ($this->type === 4) {
            return $this->value;
        }

        $values = array_map(fn (Packet $packet): int => $packet->calculate(), $this->packets);

        $result = match ($this->type) {
            0 => array_sum($values),
            1 => array_product($values),
            2 => Arrays::min($values),
            3 => Arrays::max($values),
            5 => $values[0] > $values[1] ? 1 : 0,
            6 => $values[0] < $values[1] ? 1 : 0,
            7 => $values[0] === $values[1] ? 1 : 0,
            default => throw new \RuntimeException("Invalid packet type '$this->type'"),
        };

        /** @psalm-suppress DocblockTypeContradiction */
        if (!\is_int($result)) {
            throw new \RuntimeException("Unexpected result from calculation '$result'");
        }

        return $result;
    }
}
