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
            [Day9\Day9PartTwo::class, '1134', 'day-9.sample.txt'],
            [Day9\Day9PartTwo::class, '959136'],
            [Day10\Day10PartOne::class, '26397', 'day-10.sample.txt'],
            [Day10\Day10PartOne::class, '370407'],
            [Day10\Day10PartTwo::class, '288957', 'day-10.sample.txt'],
            [Day10\Day10PartTwo::class, '3249889609'],
            [Day11\Day11PartOne::class, '1656', 'day-11.sample.txt'],
            [Day11\Day11PartOne::class, '1681'],
            [Day11\Day11PartTwo::class, '195', 'day-11.sample.txt'],
            [Day11\Day11PartTwo::class, '276'],
            [Day12\Day12PartOne::class, '10', 'day-12.sample.1.txt'],
            [Day12\Day12PartOne::class, '19', 'day-12.sample.2.txt'],
            [Day12\Day12PartOne::class, '226', 'day-12.sample.3.txt'],
            [Day12\Day12PartOne::class, '4241'],
            [Day12\Day12PartTwo::class, '36', 'day-12.sample.1.txt'],
            [Day12\Day12PartTwo::class, '103', 'day-12.sample.2.txt'],
            [Day12\Day12PartTwo::class, '3509', 'day-12.sample.3.txt'],
            [Day12\Day12PartTwo::class, '122134'],
            [Day13\Day13PartOne::class, '17', 'day-13.sample.txt'],
            [Day13\Day13PartOne::class, '743'],
            [
                Day13\Day13PartTwo::class,
                <<<OUTPUT
                #####
                #...#
                #...#
                #...#
                #####
                .....
                .....
                OUTPUT,
                'day-13.sample.txt',
            ],
            [
                Day13\Day13PartTwo::class,
                <<<OUTPUT
                ###...##..###..#.....##..#..#.#..#.#....
                #..#.#..#.#..#.#....#..#.#.#..#..#.#....
                #..#.#....#..#.#....#..#.##...####.#....
                ###..#....###..#....####.#.#..#..#.#....
                #.#..#..#.#....#....#..#.#.#..#..#.#....
                #..#..##..#....####.#..#.#..#.#..#.####.
                OUTPUT,
            ],
            [Day14\Day14PartOne::class, '1588', 'day-14.sample.txt'],
            [Day14\Day14PartOne::class, '2590'],
            [Day14\Day14PartTwo::class, '2188189693529', 'day-14.sample.txt'],
            [Day14\Day14PartTwo::class, '2875665202438'],
            [Day15\Day15PartOne::class, '40', 'day-15.sample.txt'],
            [Day15\Day15PartOne::class, '714'],
            [Day15\Day15PartTwo::class, '315', 'day-15.sample.txt'],
            [Day15\Day15PartTwo::class, '2948'],
            [Day16\Day16PartOne::class, '16', 'day-16.sample.1.txt'],
            [Day16\Day16PartOne::class, '12', 'day-16.sample.2.txt'],
            [Day16\Day16PartOne::class, '23', 'day-16.sample.3.txt'],
            [Day16\Day16PartOne::class, '31', 'day-16.sample.4.txt'],
            [Day16\Day16PartOne::class, '1002'],
            [Day16\Day16PartTwo::class, '3', 'day-16.sample.5.txt'],
            [Day16\Day16PartTwo::class, '54', 'day-16.sample.6.txt'],
            [Day16\Day16PartTwo::class, '7', 'day-16.sample.7.txt'],
            [Day16\Day16PartTwo::class, '9', 'day-16.sample.8.txt'],
            [Day16\Day16PartTwo::class, '1', 'day-16.sample.9.txt'],
            [Day16\Day16PartTwo::class, '0', 'day-16.sample.10.txt'],
            [Day16\Day16PartTwo::class, '0', 'day-16.sample.11.txt'],
            [Day16\Day16PartTwo::class, '1', 'day-16.sample.12.txt'],
            [Day16\Day16PartTwo::class, '1673210814091'],
            [Day17\Day17PartOne::class, '45', 'day-17.sample.txt'],
            [Day17\Day17PartOne::class, '11781'],
            [Day17\Day17PartTwo::class, '112', 'day-17.sample.txt'],
            [Day17\Day17PartTwo::class, '4531'],
            [Day18\Day18PartOne::class, '4140', 'day-18.sample.txt'],
            [Day18\Day18PartOne::class, '4176'],
            [Day18\Day18PartTwo::class, '3993', 'day-18.sample.txt'],
            [Day18\Day18PartTwo::class, '4633'],
            [Day19\Day19PartOne::class, '79', 'day-19.sample.txt'],
            [Day19\Day19PartOne::class, '454'],
            [Day19\Day19PartTwo::class, '3621', 'day-19.sample.txt'],
            [Day19\Day19PartTwo::class, '10813'],
        ];
    }
}
