<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021;

class TaskList
{
    /** @var array<string, class-string<TaskInterface>> */
    private const TASK_LIST = [
        '1-1' => Day1\Day1PartOne::class,
        '1-2' => Day1\Day1PartTwo::class,
        '2-1' => Day2\Day2PartOne::class,
        '2-2' => Day2\Day2PartTwo::class,
        '3-1' => Day3\Day3PartOne::class,
        '3-2' => Day3\Day3PartTwo::class,
        '4-1' => Day4\Day4PartOne::class,
        '4-2' => Day4\Day4PartTwo::class,
        '5-1' => Day5\Day5PartOne::class,
        '5-2' => Day5\Day5PartTwo::class,
        '6-1' => Day6\Day6PartOne::class,
        '6-2' => Day6\Day6PartTwo::class,
        '7-1' => Day7\Day7PartOne::class,
        '7-2' => Day7\Day7PartTwo::class,
        '8-1' => Day8\Day8PartOne::class,
    ];

    /**
     * @return array<string, class-string<TaskInterface>>
     */
    public function getTasks(): array
    {
        return self::TASK_LIST;
    }

    public function hasTask(string $name): bool
    {
        return isset(self::TASK_LIST[$name]);
    }

    public function getTask(string $name): TaskInterface
    {
        if (!$this->hasTask($name)) {
            throw new \InvalidArgumentException("Invalid task name '$name'");
        }

        $class = self::TASK_LIST[$name];

        return new $class();
    }
}
