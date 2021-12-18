<?php

namespace Riimu\AdventOfCode2021\Day18;

use Riimu\AdventOfCode2021\Typed\Integers;

class SnailfishParser
{
    private string $string;
    private int $position;

    public function parse(string $string): SnailfishNumber
    {
        $this->string = $string;
        $this->position = 0;

        $result = $this->parseItem();

        if (!$result instanceof SnailfishNumber) {
            throw new \RuntimeException("Ill formed snailfish number '$this->string'");
        }

        return $result;
    }

    public function parseItem(): SnailfishInterface
    {
        if ($this->consume('/\G\s*\[/', true) !== null) {
            $left = $this->parseItem();
            $this->consume('/\G\s*,/');
            $right = $this->parseItem();
            $this->consume('/\G\s*]/');

            return new SnailfishNumber($left, $right);
        }

        return new SnailfishValue(Integers::parse($this->consume('/\G\s*\d+/')));
    }

    private function consume(string $pattern, bool $optional = false): ?string
    {
        $count = preg_match($pattern, $this->string, $match, 0, $this->position);

        if ($count === 1) {
            $this->position += \strlen($match[0]);
            return $match[0];
        }

        if ($optional === false) {
            throw new \RuntimeException("Ill formed snailfish number '$this->string'");
        }

        return null;
    }
}
