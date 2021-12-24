<?php

namespace Riimu\AdventOfCode2021\Day24;

class InputValue implements ValueInterface
{
    public function __construct(
        private readonly int $number
    ) {
    }

    public function getExpression(): string
    {
        return sprintf('$input[%d]', $this->number);
    }
}
