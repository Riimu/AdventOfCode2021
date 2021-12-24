<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day24;

class ExpressionValue implements ValueInterface
{
    public function __construct(
        private readonly string $expression
    ) {
    }

    public function getExpression(): string
    {
        return sprintf('(%s)', $this->expression);
    }
}
