<?php

namespace Riimu\AdventOfCode2021\Day24;

class VariableValue implements ValueInterface
{
    public function __construct(
        private readonly string $name
    ) {
    }

    public function getExpression(): string
    {
        return sprintf('$%s', $this->name);
    }
}
