<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Typed;

class Files
{
    public static function getCurrentWorkingDirectory(): string
    {
        $directory = getcwd();

        if (!\is_string($directory)) {
            throw new \RuntimeException('Unable to get the current working directory');
        }

        return $directory;
    }

    public static function getContents(string $filename): string
    {
        $content = file_get_contents($filename);

        if (!\is_string($content)) {
            throw new \RuntimeException("Error reading file '$filename'");
        }

        return $content;
    }
}
