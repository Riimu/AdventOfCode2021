<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day19;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;
use Riimu\AdventOfCode2021\Typed\Regex;

class Day19PartOne extends AbstractTask
{
    private const MINIMUM_MATCH = 12;
    private const ORIGIN = 0;
    private const ORIENTATIONS = [
        [1, 2, 3],
        [1, 3, -2],
        [1, -2, -3],
        [1, -3, 2],

        [-1, 2, -3],
        [-1, 3, 2],
        [-1, -2, 3],
        [-1, -3, -2],

        [2, -1, 3],
        [2, 3, 1],
        [2, 1, -3],
        [2, -3, -1],

        [-2, 1, 3],
        [-2, 3, -1],
        [-2, -1, -3],
        [-2, -3, 1],

        [3, 2, -1],
        [3, -1, -2],
        [3, -2, 1],
        [3, 1, 2],

        [-3, 2, 1],
        [-3, 1, -2],
        [-3, -2, -1],
        [-3, -1, 2],
    ];

    protected static string $taskName = 'Day 19: Beacon Scanner';

    public function run(): string
    {
        $scannerInput = Regex::split('/\R\R/', $this->getInput('day-19.txt'));

        $scanners = [];

        foreach ($scannerInput as $input) {
            $aLines = \array_slice(Regex::split('/\R/', $input), 1);
            $probes = [];

            foreach ($aLines as $line) {
                $probes[] = array_map(
                    fn (string $value): int => Integers::parse($value),
                    Regex::split('/,/', $line)
                );
            }

            $scanners[] = $probes;
        }

        $distances = [];

        foreach ($scanners as $key => $probes) {
            $count = \count($probes);

            for ($i = 0; $i < $count - 1; $i++) {
                for ($j = $i + 1; $j < $count; $j++) {
                    $distance =
                        abs($probes[$j][0] - $probes[$i][0]) +
                        abs($probes[$j][1] - $probes[$i][1]) +
                        abs($probes[$j][2] - $probes[$i][2]);
                    $distances[$key][$distance][] = [$i, $j, $distance];
                }
            }

            ksort($distances[$key]);
        }

        $chain = [];
        $probeCoordinates = $scanners[self::ORIGIN];
        $scannerCoordinates = [self::ORIGIN => [0, 0, 0]];

        $minimumMatch = array_sum(range(1, self::MINIMUM_MATCH - 1));

        $queue = [self::ORIGIN];
        $visited = [self::ORIGIN => true];

        while ($queue !== []) {
            $a = Arrays::shift($queue);

            foreach ($scanners as $b => $bProbes) {
                if (isset($visited[$b])) {
                    continue;
                }

                $intersecting = array_intersect_key($distances[$a], $distances[$b]);
                $aLines = array_merge(... $intersecting);

                if (\count($aLines) < $minimumMatch) {
                    continue;
                }

                $matchingAProbes = [];
                $matchingBProbes = [];

                foreach ($aLines as [$probeA, $probeB, $distance]) {
                    $matchingAProbes[$probeA][] = $distance;
                    $matchingAProbes[$probeB][] = $distance;
                }

                $bLines = array_merge(... array_intersect_key($distances[$b], $intersecting));

                foreach ($bLines as [$probeA, $probeB, $distance]) {
                    $matchingBProbes[$probeA][] = $distance;
                    $matchingBProbes[$probeB][] = $distance;
                }

                foreach ($matchingAProbes as $aProbeId => $aDistances) {
                    foreach ($matchingBProbes as $bProbeId => $bDistances) {
                        if (\count(array_intersect($aDistances, $bDistances)) >= self::MINIMUM_MATCH - 1) {
                            $aNormalized = $this->shiftOrigo($scanners[$a], ... $scanners[$a][$aProbeId]);
                            $bNormalized = $this->shiftOrigo($bProbes, ... $bProbes[$bProbeId]);

                            foreach ($this->eachHeading($bNormalized) as $heading => $points) {
                                $matching = 0;

                                foreach ($points as $point) {
                                    if (\in_array($point, $aNormalized, true)) {
                                        $matching++;
                                    }
                                }

                                if ($matching >= self::MINIMUM_MATCH) {
                                    $scannerA = Arrays::last($aNormalized);
                                    $scannerB = Arrays::last($points);

                                    $x = $scannerA[0] - $scannerB[0];
                                    $y = $scannerA[1] - $scannerB[1];
                                    $z = $scannerA[2] - $scannerB[2];

                                    $chain[$b] = [$a, $heading, $x, $y, $z];

                                    $chainCoordinates = [[0, 0, 0], ... $bProbes];

                                    for ($next = $b; $next !== self::ORIGIN; $next = $target) {
                                        [$target, $orientation, $shiftX, $shiftY, $shiftZ] = $chain[$next];

                                        $chainCoordinates
                                            = $this->orient($chainCoordinates, ... self::ORIENTATIONS[$orientation]);
                                        $chainCoordinates
                                            = $this->shiftOrigo($chainCoordinates, $shiftX, $shiftY, $shiftZ);
                                    }

                                    $scannerCoordinates[$b] = Arrays::first($chainCoordinates);

                                    foreach ($chainCoordinates as $point) {
                                        if (!\in_array($point, $probeCoordinates, true)) {
                                            $probeCoordinates[] = $point;
                                        }
                                    }

                                    $queue[] = $b;
                                    $visited[$b] = true;

                                    continue 4;
                                }
                            }
                        }
                    }
                }
            }
        }

        foreach ($scannerCoordinates as $point) {
            $key = array_search($point, $probeCoordinates, true);

            if ($key !== false) {
                unset($probeCoordinates[$key]);
            }
        }

        return (string)\count($probeCoordinates);
    }

    private function shiftOrigo(array $coordinates, int $shiftX, int $shiftY, int $shiftZ): array
    {
        $shifted = [];

        foreach ($coordinates as [$x, $y, $z]) {
            $shifted[] = [
                $x - $shiftX,
                $y - $shiftY,
                $z - $shiftZ,
            ];
        }

        $shifted[] = [-$shiftX, -$shiftY, -$shiftZ];

        return $shifted;
    }

    private function eachHeading(array $coordinates): iterable
    {
        foreach (self::ORIENTATIONS as $orientation => [$x, $y, $z]) {
            yield $orientation => $this->orient($coordinates, $x, $y, $z);
        }
    }

    private function orient(array $coordinates, int $x, int $y, int $z): array
    {
        $oriented = [];

        foreach ($coordinates as $point) {
            $oriented[] = [
                $point[abs($x) - 1] * ($x <=> 0),
                $point[abs($y) - 1] * ($y <=> 0),
                $point[abs($z) - 1] * ($z <=> 0),
            ];
        }

        return $oriented;
    }
}
