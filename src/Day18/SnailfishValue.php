<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day18;

class SnailfishValue implements SnailfishInterface
{
    private ?SnailfishNumber $parent;

    public function __construct(
        private int $value,
    ) {
        $this->parent = null;
    }

    public function setParent(SnailfishNumber $number): void
    {
        $this->parent = $number;
    }

    public function split(): bool
    {
        if ($this->value < 10) {
            return false;
        }

        if ($this->parent === null) {
            throw new \RuntimeException('Cannot split value without a parent');
        }

        $left = intdiv($this->value, 2);
        $right = $this->value - $left;

        $this->parent->replace($this, new SnailfishNumber(
            new SnailfishValue($left),
            new SnailfishValue($right),
        ));

        return true;
    }

    public function addLeft(SnailfishValue $number): void
    {
        $this->value += $number->value;
    }

    public function addRight(SnailfishValue $number): void
    {
        $this->value += $number->value;
    }

    public function getMagnitude(): int
    {
        return $this->value;
    }

    public function toString(): string
    {
        return (string)$this->value;
    }
}
