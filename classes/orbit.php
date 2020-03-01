<?php

declare(strict_types=1);

/* This class contains orbits details. */
class Orbit
{
    /** @var array ORBITS */
    const ORBITS = [
        'ORBIT1' => ['distance' => 18, 'craters' => 20],
        'ORBIT2' => ['distance' => 20, 'craters' => 10],
    ];

    /** @var string $weather */
    private $weather;

    /** @var array $orbitSpeeds */
    private $orbitSpeeds;

    /**
     * @param string $weather
     * @param array $orbitSpeeds
     */
    public function __construct(string $weather, array $orbitSpeeds)
    {
        $this->weather = $weather;
        $this->orbitSpeeds = $orbitSpeeds;
    }

    /**
     * Returns the orbits details.
     *
     * @return array
     */
    public function orbits(): array
    {
        $orbits = self::ORBITS;
        $index = 0;
        foreach ($orbits as $orbit => $properties) {
            $orbits[$orbit]['craters'] = $this->craters($properties['craters']);
            $orbits[$orbit]['traffic_speed'] = $this->orbitSpeeds[$index];
            $index++;
        }

        return $orbits;
    }

    /**
     * Depending on the weather condition the number of craters will get affected.
     *
     * @param int $craters
     *
     * @return float
     */
    private function craters(int $craters): float
    {
        Switch ($this->weather) {
            case 'sunny':
                $craters = $craters * 0.9;
                break;
            case 'rainy':
                $craters = $craters * 1.2;
                break;
        }

        return $craters;
    }
}