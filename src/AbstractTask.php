<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021;

use Riimu\AdventOfCode2021\Typed\Files;
use Riimu\AdventOfCode2021\Typed\Regex;
use Symfony\Component\Filesystem\Path;

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
        return Regex::split('/\R/', $this->getInput($filename));
    }

    protected function getInput(string $defaultFilename): string
    {
        return trim(Files::getContents($this->getInputFile($defaultFilename)));
    }

    private function getInputFile(string $defaultFilename): string
    {
        $filename = $this->inputFile ?? $defaultFilename;
        $inputPath = Path::canonicalize(__DIR__ . '/../inputs/' . basename($filename));

        if (is_file($inputPath)) {
            return $inputPath;
        }

        $currentPath = Path::makeAbsolute($filename, Files::getCurrentWorkingDirectory());

        if (is_file($currentPath)) {
            return $currentPath;
        }

        throw new \RuntimeException("Could find or access input file '$filename'");
    }
}
