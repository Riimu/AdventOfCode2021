<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day16;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;
use Riimu\AdventOfCode2021\Typed\Regex;

abstract class AbstractDay16Task extends AbstractTask
{
    public function run(): string
    {
        $stream = fopen('php://memory', 'rwb');

        fwrite($stream, strtr($this->getInput('day-16.txt'), [
            '0' => '0000',
            '1' => '0001',
            '2' => '0010',
            '3' => '0011',
            '4' => '0100',
            '5' => '0101',
            '6' => '0110',
            '7' => '0111',
            '8' => '1000',
            '9' => '1001',
            'A' => '1010',
            'B' => '1011',
            'C' => '1100',
            'D' => '1101',
            'E' => '1110',
            'F' => '1111',
        ]));


        fseek($stream, 0);

        return (string)$this->calculateResult(Arrays::first($this->parsePackets($stream, 1)));
    }

    abstract protected function calculateResult(Packet $packet): int;

    /**
     * @param resource $stream
     * @param int $count
     * @return array<int, Packet>
     */
    private function parsePackets($stream, int $count): array
    {
        $packets = [];

        for ($total = 0; $total < $count; $total++) {
            $version = bindec(fread($stream, 3));
            $type = bindec(fread($stream, 3));

            if ($type === 4) {
                $packets[] = new Packet($version, $type, $this->parseLiteral($stream), []);
                continue;
            }

            $packets[] = new Packet($version, $type, 0, $this->parseOperator($stream));
        }

        return $packets;
    }

    private function parseLiteral($stream): int
    {
        $binary = '';

        do {
            $continue = fread($stream, 1);
            $binary .= fread($stream, 4);
        } while ($continue === '1');

        return bindec($binary);
    }

    private function parseOperator($stream): array
    {
        $type = bindec(fread($stream, 1));

        if ($type === 0) {
            $subStream = fopen('php://memory', 'rwb');
            $binary = fread($stream, 15);
            $length = bindec($binary);
            fwrite($subStream, fread($stream, $length));
            fseek($subStream, 0);

            $packets = [];

            while (ftell($subStream) < $length - 10) {
                $packets[] = Arrays::first($this->parsePackets($subStream, 1));
            }

            return $packets;
        }

        return $this->parsePackets($stream, bindec(fread($stream, 11)));
    }
}
