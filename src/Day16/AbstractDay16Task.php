<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day16;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\File;
use Riimu\AdventOfCode2021\Typed\Integers;

abstract class AbstractDay16Task extends AbstractTask
{
    public function run(): string
    {
        $stream = new File('php://memory', 'rwb');

        $stream->write(strtr($this->getInput('day-16.txt'), [
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


        $stream->seek(0);

        return (string)$this->calculateResult(Arrays::first($this->parsePackets($stream, 1)));
    }

    abstract protected function calculateResult(Packet $packet): int;

    /**
     * @param File $stream
     * @param int $count
     * @return array<int, Packet>
     */
    private function parsePackets(File $stream, int $count): array
    {
        $packets = [];

        for ($total = 0; $total < $count; $total++) {
            $version = Integers::fromBinary($stream->read(3));
            $type = Integers::fromBinary($stream->read(3));

            if ($type === 4) {
                $packets[] = new Packet($version, $type, $this->parseLiteral($stream), []);
                continue;
            }

            $packets[] = new Packet($version, $type, 0, $this->parseOperator($stream));
        }

        return $packets;
    }

    private function parseLiteral(File $stream): int
    {
        $binary = '';

        do {
            $continue = $stream->read(1);
            $binary .= $stream->read(4);
        } while ($continue === '1');

        return (int)bindec($binary);
    }

    /**
     * @param File $stream
     * @return array<int, Packet>
     */
    private function parseOperator(File $stream): array
    {
        $type = Integers::fromBinary($stream->read(1));

        if ($type === 0) {
            $length = Integers::fromBinary($stream->read(15));

            $subStream = new File('php://memory', 'rwb');
            $subStream->write($stream->read($length));
            $subStream->seek(0);

            $packets = [];

            while ($subStream->tell() < $length - 10) {
                $packets[] = Arrays::first($this->parsePackets($subStream, 1));
            }

            return $packets;
        }

        return $this->parsePackets($stream, Integers::fromBinary($stream->read(11)));
    }
}
