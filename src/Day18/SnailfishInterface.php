<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day18;

interface SnailfishInterface
{
    public function setParent(SnailfishNumber $number): void;
    public function split(): bool;
    public function addLeft(SnailfishValue $number): void;
    public function addRight(SnailfishValue $number): void;
    public function getMagnitude(): int;
    public function toString(): string;
}
