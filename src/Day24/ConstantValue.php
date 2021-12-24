<?php

namespace Riimu\AdventOfCode2021\Day24;

class ConstantValue implements ValueInterface
{
    public function __construct(
        public readonly int $value
    ) {
    }

    public function getExpression(): string
    {
        return (string)$this->value;
    }
}
