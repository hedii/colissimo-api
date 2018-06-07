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
$colissimoApi = new \Hedii\ColissimoApi\ColissimoApi();

// get data
$all         = $colissimoApi->get('9V01144114240')->all();
$status      = $colissimoApi->get('9V01144114240')->status();
$id          = $colissimoApi->get('9V01144114240')->id();
$destination = $colissimoApi->get('9V01144114240')->destination();
var_dump($all, $status, $id, $destination);

// show json
$colissimoApi->show('9V01144114240')->all();
$colissimoApi->show('9V01144114240')->status();
$colissimoApi->show('9V01144114240')->id();
$colissimoApi->show('9V01144114240')->destination();

````

### Run tests

````bash
vendor/bin/phpunit tests
````
You may need to update the id in */tests/ColissimoApiTest.php* because the id is only valid for 90 days.
