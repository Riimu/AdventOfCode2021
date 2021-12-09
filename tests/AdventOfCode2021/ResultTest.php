<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021;

use PHPUnit\Framework\TestCase;

/** @psalm-suppress PropertyNotSetInConstructor */
class ResultTest extends TestCase
{
    /** @dataProvider getTaskResults */
    public function testTaskResults(string $taskClass, string $expectedResult, ?string $override = null): void
    {
        if (!is_a($taskClass, TaskInterface::class, true)) {
            throw new \RuntimeException("Invalid task class '$taskClass");
        }

        $task = new $taskClass();

        if ($override !== null) {
            $task->setInput($override);
        }

        $this->assertSame($expectedResult, $task->run());
    }

    /**
     * @return array<array<string>>
     */
    public function getTaskResults(): array
    {
        return [
            [Day1\Day1PartOne::class, '7', 'day-1.sample.txt'],
            [Day1\Day1PartOne::class, '1446'],
            [Day1\Day1PartTwo::class, '5', 'day-1.sample.txt'],
            [Day1\Day1PartTwo::class, '1486'],
            [Day2\Day2PartOne::class, '150', 'day-2.sample.txt'],
            [Day2\Day2PartOne::class, '1250395'],
            [Day2\Day2PartTwo::class, '900', 'day-2.sample.txt'],
            [Day2\Day2PartTwo::class, '1451210346'],
            [Day3\Day3PartOne::class, '198', 'day-3.sample.txt'],
            [Day3\Day3PartOne::class, '2648450'],
            [Day3\Day3PartTwo::class, '230', 'day-3.sample.txt'],
            [Day3\Day3PartTwo::class, '2845944'],
            [Day4\Day4PartOne::class, '4512', 'day-4.sample.txt'],
            [Day4\Day4PartOne::class, '51776'],
            [Day4\Day4PartTwo::class, '1924', 'day-4.sample.txt'],
            [Day4\Day4PartTwo::class, '16830'],
            [Day5\Day5PartOne::class, '5', 'day-5.sample.txt'],
            [Day5\Day5PartOne::class, '6461'],
            [Day5\Day5PartTwo::class, '12', 'day-5.sample.txt'],
            [Day5\Day5PartTwo::class, '18065'],
            [Day6\Day6PartOne::class, '5934', 'day-6.sample.txt'],
            [Day6\Day6PartOne::class, '362740'],
            [Day6\Day6PartTwo::class, '26984457539', 'day-6.sample.txt'],
            [Day6\Day6PartTwo::class, '1644874076764'],
            [Day7\Day7PartOne::class, '37', 'day-7.sample.txt'],
            [Day7\Day7PartOne::class, '356992'],
            [Day7\Day7PartTwo::class, '168', 'day-7.sample.txt'],
            [Day7\Day7PartTwo::class, '101268110'],
            [Day8\Day8PartOne::class, '26', 'day-8.sample.txt'],
            [Day8\Day8PartOne::class, '548'],
            [Day8\Day8PartTwo::class, '61229', 'day-8.sample.txt'],
            [Day8\Day8PartTwo::class, '1074888'],
            [Day9\Day9PartOne::class, '15', 'day-9.sample.txt'],
            [Day9\Day9PartOne::class, '560'],
        ];
    }
}
