<?php

namespace Riimu\AdventOfCode2021;

use PHPUnit\Framework\TestCase;
use Riimu\AdventOfCode2021\Day18\SnailfishParser;
use Riimu\AdventOfCode2021\Typed\Arrays;

class SnailfishTest extends TestCase
{
    /** @dataProvider getParserTestCases */
    public function testParser(string $number)
    {
        $this->assertSame($number, (new SnailfishParser())->parse($number)->toString());
    }

    public function getParserTestCases(): array
    {
        return [
            ['[1,2]'],
            ['[[1,2],3]'],
            ['[9,[8,7]]'],
            ['[[1,9],[8,5]]'],
            ['[[[[1,2],[3,4]],[[5,6],[7,8]]],9]'],
            ['[[[9,[3,8]],[[0,9],6]],[[[3,7],[4,9]],3]]'],
            ['[[[[1,3],[5,3]],[[1,3],[8,7]]],[[[4,9],[6,9]],[[8,2],[7,3]]]]'],
        ];
    }

    /** @dataProvider getExplodeTestCases */
    public function testExplode(string $expected, string $number)
    {
        $parser = new SnailfishParser();

        $parsed = $parser->parse($number);
        $parsed->explode();

        $this->assertSame($expected, $parsed->toString());
    }

    public function getExplodeTestCases()
    {
        return [
            ['[[[[0,9],2],3],4]', '[[[[[9,8],1],2],3],4]'],
            ['[7,[6,[5,[7,0]]]]', '[7,[6,[5,[4,[3,2]]]]]'],
            ['[[6,[5,[7,0]]],3]', '[[6,[5,[4,[3,2]]]],1]'],
            ['[[3,[2,[8,0]]],[9,[5,[4,[3,2]]]]]', '[[3,[2,[1,[7,3]]]],[6,[5,[4,[3,2]]]]]'],
            ['[[3,[2,[8,0]]],[9,[5,[7,0]]]]', '[[3,[2,[8,0]]],[9,[5,[4,[3,2]]]]]'],
        ];
    }

    /** @dataProvider getAdditionTestCases */
    public function testAddition(string $expected, array $numbers)
    {
        $parser = new SnailfishParser();
        $result = $parser->parse(Arrays::shift($numbers));

        foreach ($numbers as $number) {
            $result->add($parser->parse($number));
        }

        $this->assertSame($expected, $result->toString());
    }

    public function getAdditionTestCases()
    {
        return [
            ['[[[[0,7],4],[[7,8],[6,0]]],[8,1]]', [
                '[[[[4,3],4],4],[7,[[8,4],9]]]',
                '[1,1]'
            ]],
            ['[[[[1,1],[2,2]],[3,3]],[4,4]]', [
                '[1,1]',
                '[2,2]',
                '[3,3]',
                '[4,4]',
            ]],
            ['[[[[3,0],[5,3]],[4,4]],[5,5]]', [
                '[1,1]',
                '[2,2]',
                '[3,3]',
                '[4,4]',
                '[5,5]',
            ]],
            ['[[[[5,0],[7,4]],[5,5]],[6,6]]', [
                '[1,1]',
                '[2,2]',
                '[3,3]',
                '[4,4]',
                '[5,5]',
                '[6,6]',
            ]],
            ['[[[[8,7],[7,7]],[[8,6],[7,7]]],[[[0,7],[6,6]],[8,7]]]', [
                '[[[0,[4,5]],[0,0]],[[[4,5],[2,6]],[9,5]]]',
                '[7,[[[3,7],[4,3]],[[6,3],[8,8]]]]',
                '[[2,[[0,8],[3,4]]],[[[6,7],1],[7,[1,6]]]]',
                '[[[[2,4],7],[6,[0,5]]],[[[6,8],[2,8]],[[2,1],[4,5]]]]',
                '[7,[5,[[3,8],[1,4]]]]',
                '[[2,[2,2]],[8,[8,1]]]',
                '[2,9]',
                '[1,[[[9,3],9],[[9,0],[0,7]]]]',
                '[[[5,[7,4]],7],1]',
                '[[[[4,2],2],6],[8,7]]',
            ]]
        ];
    }

    /** @dataProvider getMagnitudeTestCases */
    public function testMagnitude(int $expected, string $number): void
    {
        $this->assertSame($expected, (new SnailfishParser())->parse($number)->getMagnitude());
    }

    public function getMagnitudeTestCases(): array
    {
        return [
            [29, '[9,1]'],
            [21, '[1,9]'],
            [129, '[[9,1],[1,9]]'],
            [143, '[[1,2],[[3,4],5]]'],
            [1384, '[[[[0,7],4],[[7,8],[6,0]]],[8,1]]'],
            [445, '[[[[1,1],[2,2]],[3,3]],[4,4]]'],
            [791, '[[[[3,0],[5,3]],[4,4]],[5,5]]'],
            [1137, '[[[[5,0],[7,4]],[5,5]],[6,6]]'],
            [3488, '[[[[8,7],[7,7]],[[8,6],[7,7]]],[[[0,7],[6,6]],[8,7]]]'],
        ];
    }
}
