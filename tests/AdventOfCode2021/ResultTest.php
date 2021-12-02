<?php

namespace Riimu\AdventOfCode2021;

use PHPUnit\Framework\TestCase;

/** @psalm-suppress PropertyNotSetInConstructor */
class ResultTest extends TestCase
{
    /**
     * @param class-string<TaskInterface> $taskClass
     * @param string $expectedResult
     * @dataProvider getTaskResults
     */
    public function testTaskResults(string $taskClass, string $expectedResult): void
    {
        $task = new $taskClass();

        $this->assertInstanceOf(TaskInterface::class, $task);
        $this->assertSame($expectedResult, $task->run());
    }

    /**
     * @return array<array<string>>
     */
    public function getTaskResults(): array
    {
        return [
            [Day1\Day1PartOne::class, '1446'],
            [Day1\Day1PartTwo::class, '1486'],
            [Day2\Day2PartOne::class, '1250395'],
            [Day2\Day2PartTwo::class, '1451210346'],
        ];
    }
}
