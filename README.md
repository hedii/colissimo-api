[![Build Status](https://travis-ci.org/hedii/colissimo-api.svg?branch=master)](https://travis-ci.org/hedii/colissimo-api)

# colissimo-api
A php package to track Colissimo (La Poste) parcels

### Requirements
- PHP >= 7.1
- XML PHP Extension
- Curl PHP Extension

### Installation
````bash
composer require hedii/colissimo-api
````

### Usage
````php
require 'vendor/autoload.php';

$colissimo = new \Hedii\ColissimoApi\ColissimoApi();

try {
    $result = $colissimo->get('your_colissimo_id_here');
} catch (\Hedii\ColissimoApi\ColissimoApiException $e) {
    // ...
}
````

The result is an array of chronological status:
````
array(5) {
  [0] =>
  array(3) {
    'date' =>
    string(10) "30/05/2018"
    'label' =>
    string(23) "Votre colis est livré."
    'location' =>
    string(18) "Centre Courrier 75"
  }
  [1] =>
  array(3) {
    'date' =>
    string(10) "30/05/2018"
    'label' =>
    string(50) "Votre colis est en préparation pour la livraison."
    'location' =>
    string(18) "Centre Courrier 75"
  }
  [2] =>
  array(3) {
    'date' =>
    string(10) "30/05/2018"
    'label' =>
    string(52) "Votre colis est arrivé sur son site de distribution"
    'location' =>
    string(18) "Centre Courrier 75"
  }
  [3] =>
  array(3) {
    'date' =>
    string(10) "29/05/2018"
    'label' =>
    string(40) "Votre colis est en cours d'acheminement."
    'location' =>
    string(16) "Plateforme Colis"
  }
  [4] =>
  array(3) {
    'date' =>
    string(10) "28/05/2018"
    'label' =>
    string(110) "Votre colis a été déposé après l'heure limite de dépôt. Il sera expédié dès le prochain jour ouvré."
    'location' =>
    string(28) "Bureau de Poste Les estables"
  }
}
````

### Run tests

````bash
composer test
````
You may need to update the id in */tests/ColissimoApiTest.php* because the id is only valid for 90 days.
