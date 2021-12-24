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
        '8-2' => Day8\Day8PartTwo::class,
        '9-1' => Day9\Day9PartOne::class,
        '9-2' => Day9\Day9PartTwo::class,
        '10-1' => Day10\Day10PartOne::class,
        '10-2' => Day10\Day10PartTwo::class,
        '11-1' => Day11\Day11PartOne::class,
        '11-2' => Day11\Day11PartTwo::class,
        '12-1' => Day12\Day12PartOne::class,
        '12-2' => Day12\Day12PartTwo::class,
        '13-1' => Day13\Day13PartOne::class,
        '13-2' => Day13\Day13PartTwo::class,
        '14-1' => Day14\Day14PartOne::class,
        '14-2' => Day14\Day14PartTwo::class,
        '15-1' => Day15\Day15PartOne::class,
        '15-2' => Day15\Day15PartTwo::class,
        '16-1' => Day16\Day16PartOne::class,
        '16-2' => Day16\Day16PartTwo::class,
        '17-1' => Day17\Day17PartOne::class,
        '17-2' => Day17\Day17PartTwo::class,
        '18-1' => Day18\Day18PartOne::class,
        '18-2' => Day18\Day18PartTwo::class,
        '19-1' => Day19\Day19PartOne::class,
        '19-2' => Day19\Day19PartTwo::class,
        '20-1' => Day20\Day20PartOne::class,
        '20-2' => Day20\Day20PartTwo::class,
        '21-1' => Day21\Day21PartOne::class,
        '21-2' => Day21\Day21PartTwo::class,
        '22-1' => Day22\Day22PartOne::class,
        '22-2' => Day22\Day22PartTwo::class,
        '23-1' => Day23\Day23PartOne::class,
        '23-2' => Day23\Day23PartTwo::class,
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
