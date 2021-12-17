<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Typed;

class File
{
    /** @var resource */
    private $stream;

    public function __construct(string $path, string $mode)
    {
        $stream = fopen($path, $mode);

        if (!\is_resource($stream)) {
            throw new \RuntimeException("Could not open file '$path'");
        }

        $this->stream = $stream;
    }

    public function read(int $bytes): string
    {
        if ($bytes < 0) {
            throw new \RuntimeException("Invalid number of bytes to read '$bytes'");
        }

        $contents = fread($this->stream, $bytes);

        if (!\is_string($contents) || (\strlen($contents) !== $bytes && !feof($this->stream))) {
            throw new \RuntimeException('Error reading from file');
        }

        return $contents;
    }

    public function seek(int $position): void
    {
        if (fseek($this->stream, $position) !== 0) {
            throw new \RuntimeException('Error seeking file');
        }
    }

    public function write(string $contents): void
    {
        $bytes = fwrite($this->stream, $contents);

        if ($bytes !== \strlen($contents)) {
            throw new \RuntimeException('Failed to write all the contents to file');
        }
    }

    public function tell(): int
    {
        $position = ftell($this->stream);

        if (!\is_int($position)) {
            throw new \RuntimeException('Failed to tell stream position');
        }

        return $position;
    }
}
