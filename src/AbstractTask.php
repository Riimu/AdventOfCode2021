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
        $fullPath = $this->getInputFile($defaultFilename);
        $input = file_get_contents($fullPath);

        if (!\is_string($input)) {
            throw new \RuntimeException("Error reading input file '$fullPath'");
        }

        return trim($input);
    }

    private function getInputFile(string $defaultFilename): string
    {
        $filename = $this->inputFile ?? $defaultFilename;
        $fullPath = __DIR__ . '/../inputs/' . $filename;

        if (file_exists($fullPath)) {
            return realpath($fullPath);
        }

        if (file_exists($filename)) {
            return realpath($filename);
        }

        throw new \RuntimeException("No input file '$filename' exists");
    }
}
