<?php

$inputFilePath = $argv[1];

//If the file does not exist then throw an error.
if (!file_exists($inputFilePath)) {
    throw new Exception('File does not exists');
}

require_once __DIR__ . '/classes/orbit.php';

//Get the input parameters from the file. (weather condition, orbit 1,2 speeds).
$testInput = explode(' ', file_get_contents($inputFilePath));
$weather = strtolower(array_shift($testInput));

//Create an object of the Orbit class.
$orbit = new Orbit($weather, $testInput);
//Get the orbit details.
$orbitDetails = $orbit->orbits();

require_once __DIR__ . '/classes/path_details.php';

//Create an object of the PathDetails class.
$pathDetails = new PathDetails($weather, $orbitDetails);
//Get the fastest path and vehicle taken to reach the destination.
$pathDetails->pathTaken();