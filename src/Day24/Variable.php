<?php

namespace Riimu\AdventOfCode2021\Day24;

class Variable
{
    private int $value;
    private bool $constant;
    private string $name;
    private int $input;
    private ?string $expression;

    public function __construct(int $value, string $name = '')
    {
        $this->value = $value;
        $this->constant = true;
        $this->name = $name;
        $this->input = -1;
        $this->expression = null;
    }

    public function getName(): string
    {
        if ($this->name === '') {
            throw new \RuntimeException('Cannot get the name of unnamed value');
        }

        return $this->name;
    }

    public function isConstant(): bool
    {
        return $this->constant;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
        $this->constant = true;
    }

    public function setInput(int $number): void
    {
        $this->input = $number;
        $this->constant = false;
    }

    public function setExpression(string $expression): void
    {
        $this->expression = $expression;
        $this->constant = false;
    }

    public function getAssignment(): string
    {
        if ($this->expression !== null) {
            throw new \RuntimeException('Trying to make assignment without dependents');
        }

        return sprintf('%s = %s', $this->getName(), $this->expression);
    }

    public function getExpression(): string
    {
        if ($this->expression !== null) {
            return sprintf('(%s)', $this->expression);
        }

        if ($this->constant) {
            return (string)$this->value;
        }

        if ($this->input !== -1) {
            return sprintf('$input[%d]', $this->input);
        }

        return sprintf('$%s', $this->getName());
    }
}
