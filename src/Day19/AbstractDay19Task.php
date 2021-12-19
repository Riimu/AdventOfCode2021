<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day19;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Arrays;
use Riimu\AdventOfCode2021\Typed\Integers;
use Riimu\AdventOfCode2021\Typed\Regex;

abstract class AbstractDay19Task extends AbstractTask
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

    public function run(): string
    {
        $scanners = $this->parseBeacons($this->getInput('day-19.txt'));
        $distances = $this->calculateBeaconDistances($scanners);

        $chain = [];
        $probeCoordinates = $scanners[self::ORIGIN];
        $scannerCoordinates = [self::ORIGIN => [0, 0, 0]];

        $minimumMatch = array_sum(range(1, self::MINIMUM_MATCH - 1));

        $queue = [self::ORIGIN];
        $visited = [self::ORIGIN => true];

        while ($queue !== []) {
            /** @var array<int, int> $queue */
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
                            $aNormalized = $this->shiftOrigo(
                                [... $scanners[$a], [0, 0, 0]],
                                ... $scanners[$a][$aProbeId]
                            );
                            $bNormalized = $this->shiftOrigo(
                                [... $bProbes, [0, 0, 0]],
                                ... $bProbes[$bProbeId]
                            );

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

                                    $scannerCoordinates[$b] = Arrays::shift($chainCoordinates);

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

        return (string)$this->calculateResult($scannerCoordinates, $probeCoordinates);
    }

    /**
     * @param array<int, array<int, int>> $scanners
     * @param array<int, array<int, int>> $probes
     * @return int
     */
    abstract protected function calculateResult(array $scanners, array $probes): int;

    /**
     * @param string $input
     * @return array<int, array<int, array<int, int>>>
     */
    private function parseBeacons(string $input): array
    {
        $scanners = [];

        foreach (Regex::split('/\R\R/', $input) as $section) {
            $beacons = [];

            foreach (\array_slice(Regex::split('/\R/', $section), 1) as $line) {
                $beacons[] = array_map(
                    fn (string $value): int => Integers::parse($value),
                    Regex::split('/,/', $line)
                );
            }

            $scanners[] = $beacons;
        }

        return $scanners;
    }

    /**
     * @param array<int, array<int, array<int, int>>> $scanners
     * @return array<int, array<int, array<int, array<int, int>>>>
     */
    private function calculateBeaconDistances(array $scanners): array
    {
        $distances = [];

        foreach ($scanners as $key => $beacons) {
            $count = \count($beacons);

            for ($i = 0; $i < $count - 1; $i++) {
                for ($j = $i + 1; $j < $count; $j++) {
                    $distance =
                        abs($beacons[$j][0] - $beacons[$i][0]) +
                        abs($beacons[$j][1] - $beacons[$i][1]) +
                        abs($beacons[$j][2] - $beacons[$i][2]);
                    $distances[$key][$distance][] = [$i, $j, $distance];
                }
            }

            ksort($distances[$key]);
        }

        return $distances;
    }

    /**
     * @param array<int, array<int, int>> $coordinates
     * @param int $shiftX
     * @param int $shiftY
     * @param int $shiftZ
     * @return array<int, array<int, int>>
     */
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

        return $shifted;
    }

    /**
     * @param array<int, array<int, int>> $coordinates
     * @return iterable<int, array<int, array<int, int>>>
     */
    private function eachHeading(array $coordinates): iterable
    {
        foreach (self::ORIENTATIONS as $orientation => [$x, $y, $z]) {
            yield $orientation => $this->orient($coordinates, $x, $y, $z);
        }
    }

    /**
     * @param array<int, array<int, int>> $coordinates
     * @param int $x
     * @param int $y
     * @param int $z
     * @return array<int, array<int, int>>
     */
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
