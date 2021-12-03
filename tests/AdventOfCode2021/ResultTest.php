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
        ];
    }
}
