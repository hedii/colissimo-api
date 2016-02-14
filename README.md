[![Build Status](https://travis-ci.org/hedii/colissimo-api.svg?branch=master)](https://travis-ci.org/hedii/colissimo-api)

# colissimo-api
A php API to track Colissimo (La Poste) parcels

### Installation
````bash
composer require hedii/colissimo-api
````

### Usage
````php
<?php

require 'vendor/autoload.php';

// create a new instance
$colissimoApi = new ColissimoApi();

// get data
$all         = $colissimoApi->get('9V01144112123')->all();
$status      = $colissimoApi->get('9V01144112123')->status();
$id          = $colissimoApi->get('9V01144112123')->id();
$destination = $colissimoApi->get('9V01144112123')->destination();
var_dump($all, $status, $id, $destination);

// show json
$colissimoApi->show('9V01144112123')->all();
$colissimoApi->show('9V01144112123')->status();
$colissimoApi->show('9V01144112123')->id();
$colissimoApi->show('9V01144112123')->destination();

````

### Run tests

````bash
vendor/bin/phpunit tests
````
You may need to update the id in */tests/ColissimoApiTest.php* because the id is only valid for 90 days.
