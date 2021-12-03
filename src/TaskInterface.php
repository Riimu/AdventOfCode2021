<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021;

interface TaskInterface
{
    public static function getName(): string;
    public function setInput(string $filename): void;
    public function run(): string;
}
