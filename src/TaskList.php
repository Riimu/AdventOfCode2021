<?php

namespace Riimu\AdventOfCode2021;

class TaskList
{
    /** @var array<string, class-string<TaskInterface>> */
    public const TASK_LIST = [
        '1-1' => Day1\Day1PartOne::class,
        '1-2' => Day1\Day1PartTwo::class,
        '2-1' => Day2\Day2PartOne::class,
        '2-2' => Day2\Day2PartTwo::class,
    ];
}
