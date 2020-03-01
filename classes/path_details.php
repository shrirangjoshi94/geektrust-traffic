<?php

declare(strict_types=1);

/* This class calculates the time required by a vehicle to commute a given orbit.*/
class PathDetails
{
    /** @var string $weatherCondition */
    private $weatherCondition;

    /** @var array $orbits */
    private $orbits;

    /** @var array $orbitDetails */
    private $orbitDetails;

    /** @var int $commuteTime */
    private $commuteTime = 0;

    /** @var array VEHICLE_TYPES */
    const VEHICLE_TYPES = ['BIKE', 'TUKTUK', 'CAR'];

    /**
     * @param string $weatherCondition
     * @param array $orbits
     */
    public function __construct(string $weatherCondition, array $orbits)
    {
        $this->weatherCondition = $weatherCondition;
        $this->orbits = $orbits;
    }

    /**
     * Calculates the fastest orbit and vehicle to reach the destination.
     *
     * @return void
     */
    public function pathTaken(): void
    {
        $fastestOrbit = '';
        $fastestVehicle = '';
        $time = [];

        //Iterate through our orbist array.
        foreach ($this->orbits as $orbitName => $orbitDetails) {
            $this->orbitDetails = $orbitDetails;
            //Iterate through the VEHICLE_TYPES array.
            foreach (self::VEHICLE_TYPES as $vehicle) {

                //If the commuteTime is greater than 0 then push it in $time array.
                if ($this->commuteTime) {
                    array_push($time, $this->commuteTime);
                }

                //Call the vehicle speeds dynamically.
                if (!call_user_func([$this, strtolower($vehicle)])) {
                    continue;
                }

                //If the calculated current time for the current vehicle is lesser than the previously calculated commute
                // for any other vehicle/path then it will be the fastest orbit and vehicle.
                if (count($time) > 0 && $this->commuteTime < min($time)) {
                    $fastestOrbit = $orbitName;
                    $fastestVehicle = $vehicle;
                } else if (count($time) === 0) {
                    $fastestOrbit = $orbitName;
                    $fastestVehicle = $vehicle;
                }
            }
        }

        echo $fastestVehicle . '     ' .$fastestOrbit;
    }

    /**
     * Calculates the commute time for bike.
     *
     * @return bool
     */
    private function bike(): bool
    {
        if ('rainy' === $this->weatherCondition) {
            return false;
        }

        $this->calculateCommuteTime(10, 2);

        return true;
    }

    /**
     * Calculates the commute time for tuktuk.
     *
     * @return bool
     */
    private function tuktuk(): bool
    {
        if ('windy' === $this->weatherCondition) {
            return false;
        }

        $this->calculateCommuteTime(12, 1);

        return true;
    }

    /**
     * Calculates the commute time for car.
     *
     * @return bool
     */
    private function car(): bool
    {
        $this->calculateCommuteTime(20, 3);

        return true;
    }

    /**
     * Calculates the commute time required by the vehicle.
     *
     * @param int $maxSpeed
     * @param int $craterCrossTime
     */
    private function calculateCommuteTime(int $maxSpeed, int $craterCrossTime): void
    {
        //Condition when the traffic speed is less than the vehicle speed.
        if ($maxSpeed > $this->orbitDetails['traffic_speed']) {
            $maxSpeed = $this->orbitDetails['traffic_speed'];
        }

        //Calculate the commute time in minutes.
        $this->commuteTime = ($this->orbitDetails['distance'] / $maxSpeed) * 60 +
            $this->orbitDetails['craters'] * $craterCrossTime;
    }
}