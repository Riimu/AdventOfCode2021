<?php

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
