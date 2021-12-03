<?php

namespace Riimu\AdventOfCode2021;

abstract class AbstractTask implements TaskInterface
{
    protected static string $taskName;
    private ?string $inputFile;

    public static function getName(): string
    {
        return static::$taskName;
    }

    public function setInput(string $filename): void
    {
        $this->inputFile = $filename;
    }

    protected function parseInt(string $string): int
    {
        $value = (int)$string;

        if ($string !== (string)$value) {
            throw new \RuntimeException("Unexpected integer value '$string'");
        }

        return $value;
    }

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

    protected function getInput(string $defaultFilename): string
    {
        $filename = $this->inputFile ?? $defaultFilename;
        $fullPath = __DIR__ . '/../inputs/' . $filename;

        if (!file_exists($fullPath)) {
            throw new \RuntimeException("No input file '$fullPath' exists");
        }

        $input = file_get_contents(__DIR__ . '/../inputs/' . $filename);

        if (!\is_string($input)) {
            throw new \RuntimeException("Error reading input file '$fullPath'");
        }

        return trim($input);
    }
}
