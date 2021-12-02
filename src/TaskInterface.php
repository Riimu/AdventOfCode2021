<?php

namespace Riimu\AdventOfCode2021;

interface TaskInterface
{
    public static function getName(): string;
    public function run(): string;
}
