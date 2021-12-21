<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day20;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Regex;

abstract class AbstractDay20Task extends AbstractTask
{
    protected static int $runs = 0;

    public function run(): string
    {
        [$algorithmInput, $imageInput] = Regex::split('/\R\R/', $this->getInput('day-20.txt'));

        $algorithm = [];

        foreach (str_split($algorithmInput) as $character) {
            if ($character === '.') {
                $algorithm[] = false;
            } elseif ($character === '#') {
                $algorithm[] = true;
            }
        }

        $image = [];

        foreach (Regex::split('/\R/', $imageInput) as $line) {
            $row = [];

            foreach (str_split($line) as $character) {
                if ($character === '.') {
                    $row[] = false;
                } elseif ($character === '#') {
                    $row[] = true;
                }
            }

            $image[] = $row;
        }

        $emptySpace = false;

        for ($n = 0; $n < static::$runs; $n++) {
            $height = \count($image);
            $width = \count(Arrays::first($image));
            $newImage = [];

            foreach (range(0, $height + 1) as $y) {
                foreach (range(0, $width + 1) as $x) {
                    $value = 0;

                    for ($i = -2; $i <= 0; $i++) {
                        for ($j = -2; $j <= 0; $j++) {
                            $value <<= 1;

                            if ($image[$y + $i][$x + $j] ?? $emptySpace) {
                                $value |= 1;
                            }
                        }
                    }

                    $newImage[$y][$x] = $algorithm[$value];
                }
            }

            $emptySpace = $emptySpace ? $algorithm[0b111111111] : $algorithm[0b000000000];
            $image = $newImage;
        }

        return (string)array_sum(array_map(fn ($row) => \count(array_keys($row, true, true)), $image));
    }
}
