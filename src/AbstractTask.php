<?php

namespace Riimu\AdventOfCode2021;

abstract class AbstractTask implements TaskInterface
{
    /**
     * @return array<int, string>
     */
    protected function getInputLines(string $filename): array
    {
        $input = $this->getInput($filename);
        $lines = preg_split('/\R/', $input);

        if (!\is_array($lines)) {
            throw new \RuntimeException('Error parsing input file');
        }

        return $lines;
    }

    protected function getInput(string $filename): string
    {
        $fullPath = __DIR__ . '/../inputs/' . $filename;

        if (!file_exists($fullPath)) {
            throw new \RuntimeException("No input file '$fullPath' exists");
        }

        $input = file_get_contents(__DIR__ . '/../inputs/' . $filename);

        if (!\is_string($input)) {
            throw new \RuntimeException("Error reading input file '$fullPath'");
        }

        return $input;
    }
}
