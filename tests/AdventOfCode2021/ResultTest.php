<?php

namespace Riimu\AdventOfCode2021;

use PHPUnit\Framework\TestCase;
use Riimu\AdventOfCode2021\Day1\Day1FirstStar;

class ResultTest extends TestCase
{
    /**
     * @dataProvider getTaskResults
     */
    public function testTaskResults(string $taskClass, string $expectedResult)
    {
        $task = new $taskClass();

        $this->assertInstanceOf(TaskInterface::class, $task);
        $this->assertSame($expectedResult, $task->run());
    }

    public function getTaskResults(): array
    {
        return [
            [Day1FirstStar::class, 'foobar'],
        ];
    }
}
