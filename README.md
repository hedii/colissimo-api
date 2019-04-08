[![Build Status](https://travis-ci.org/hedii/colissimo-api.svg?branch=master)](https://travis-ci.org/hedii/colissimo-api)

# colissimo-api
A php package to track Colissimo (La Poste) parcels

### Requirements
- PHP >= 7.1
- Curl PHP Extension
- Json PHP Extension

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

The result is an array of data provided by api.laposte.fr:
````
array(4) {
  ["lang"]=>
  string(5) "fr_FR"
  ["scope"]=>
  string(8) "timeline"
  ["shipment"]=>
  array(13) {
    ["idShip"]=>
    string(13) "6H002911xxxxx"
    ["notifAvailable"]=>
    bool(true)
    ["holder"]=>
    int(4)
    ["product"]=>
    string(9) "colissimo"
    ["isFinal"]=>
    bool(true)
    ["deliveryDate"]=>
    string(25) "2019-04-05T14:28:00+02:00"
    ["entryDate"]=>
    string(25) "2019-04-04T21:22:52+02:00"
    ["timeline"]=>
    array(5) {
      [0]=>
      array(6) {
        ["shortLabel"]=>
        string(30) "Votre colis est pris en charge"
        ["id"]=>
        int(1)
        ["date"]=>
        string(25) "2019-04-04T21:22:52+02:00"
        ["country"]=>
        string(0) ""
        ["status"]=>
        bool(true)
        ["type"]=>
        int(1)
      }
      [1]=>
      array(6) {
        ["shortLabel"]=>
        string(17) "Il est en chemin."
        ["longLabel"]=>
        string(0) ""
        ["id"]=>
        int(2)
        ["country"]=>
        string(0) ""
        ["status"]=>
        bool(true)
        ["type"]=>
        int(1)
      }
      [2]=>
      array(5) {
        ["shortLabel"]=>
        string(11) "Il arrive !"
        ["id"]=>
        int(3)
        ["country"]=>
        string(0) ""
        ["status"]=>
        bool(true)
        ["type"]=>
        int(1)
      }
      [3]=>
      array(6) {
        ["shortLabel"]=>
        string(51) "Votre colis vous attend dans votre point de retrait"
        ["longLabel"]=>
        string(0) ""
        ["id"]=>
        int(4)
        ["country"]=>
        string(0) ""
        ["status"]=>
        bool(true)
        ["type"]=>
        int(1)
      }
      [4]=>
      array(7) {
        ["shortLabel"]=>
        string(27) "Votre colis a été retiré"
        ["longLabel"]=>
        string(0) ""
        ["id"]=>
        int(5)
        ["date"]=>
        string(25) "2019-04-05T14:28:00+02:00"
        ["country"]=>
        string(0) ""
        ["status"]=>
        bool(true)
        ["type"]=>
        int(1)
      }
    }
    ["event"]=>
    array(5) {
      [0]=>
      array(4) {
        ["order"]=>
        int(100)
        ["status"]=>
        string(6) "LIVCFM"
        ["label"]=>
        string(23) "Votre colis est livré."
        ["date"]=>
        string(25) "2019-04-05T14:28:00+02:00"
      }
      [1]=>
      array(4) {
        ["order"]=>
        int(99)
        ["status"]=>
        string(6) "AARBPR"
        ["label"]=>
        string(195) "Votre colis est disponible dans votre point de retrait pendant un délai de 10 jours ouvrables. Ne tardez pas à aller le chercher ! Il vous sera remis sur présentation d'une pièce d'identité."
        ["date"]=>
        string(25) "2019-04-05T12:07:00+02:00"
      }
      [2]=>
      array(4) {
        ["order"]=>
        int(98)
        ["status"]=>
        string(6) "PRELIV"
        ["label"]=>
        string(116) "Votre colis est dans le site de livraison qui dessert votre adresse. Nous le préparons pour le mettre en livraison."
        ["date"]=>
        string(25) "2019-04-05T09:27:28+02:00"
      }
      [3]=>
      array(4) {
        ["order"]=>
        int(97)
        ["status"]=>
        string(6) "PCHTRI"
        ["label"]=>
        string(110) "Votre colis est en transit sur nos plateformes logistiques pour vous être livré le plus rapidement possible."
        ["date"]=>
        string(25) "2019-04-04T21:22:52+02:00"
      }
      [4]=>
      array(4) {
        ["order"]=>
        int(96)
        ["status"]=>
        string(6) "PCHMQT"
        ["label"]=>
        string(200) "Votre Colissimo va bientôt nous être confié ! Il est en train d’être préparé chez votre expéditeur. Si vous avez des questions, vous pouvez contacter votre expéditeur ou son service clients."
        ["date"]=>
        string(25) "2019-04-04T16:46:30+02:00"
      }
    }
    ["contextData"]=>
    array(6) {
      ["isParcelBack"]=>
      bool(false)
      ["removalPoint"]=>
      array(4) {
        ["idPoint"]=>
        string(6) "319220"
        ["type"]=>
        string(3) "A2P"
        ["name"]=>
        string(19) "TOULOUSE ROQUELAINE"
        ["isDiffPoint"]=>
        bool(false)
      }
      ["deliveryChoice"]=>
      array(6) {
        ["deliveryChoice"]=>
        int(0)
        ["accola"]=>
        int(0)
        ["thirdParty"]=>
        int(0)
        ["safePlace"]=>
        int(0)
        ["BALCS"]=>
        int(0)
        ["extensionBP"]=>
        int(0)
      }
      ["recipient"]=>
      array(8) {
        ["name"]=>
        string(14) "M. JOHN DOE"
        ["companyName"]=>
        string(0) ""
        ["adr2"]=>
        string(23) "12 RUE DU PONT"
        ["adr3"]=>
        string(0) ""
        ["adr4"]=>
        string(0) ""
        ["adr5"]=>
        string(0) ""
        ["zipCode"]=>
        string(5) "31000"
        ["city"]=>
        string(8) "TOULOUSE"
      }
      ["originCountry"]=>
      string(2) "FR"
      ["arrivalCountry"]=>
      string(2) "FR"
    }
    ["estimDate"]=>
    string(25) "2019-04-05T02:00:00+02:00"
    ["estimHourMin"]=>
    string(25) "2019-04-08T18:00:36+02:00"
    ["estimHourMax"]=>
    string(25) "2019-04-08T18:00:36+02:00"
  }
  ["returnCode"]=>
  int(200)
}
````

### Run tests

````bash
composer test
````
You may need to update the id in */tests/ColissimoApiTest.php* because the id is only valid for 90 days.
