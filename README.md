[![Build Status](https://travis-ci.org/hedii/colissimo-api.svg?branch=master)](https://travis-ci.org/hedii/colissimo-api)
# ColissimoApi
A php API to track Colissimo (La Poste) parcels.

**Demo**: http://hedichaibi.com/colissimo-api/?id= *(fill the url with a valid colissimo id)*

## Installation
##### With composer
```bash
composer require hedii/colissimo-api
```

##### With git clone
```bash
git clone https://github.com/hedii/colissimo-api.git
```

## Usage
##### With composer
```php
<?php
use ColissimoApi\ColissimoApi;

require __DIR__ . '/vendor/autoload.php';

header('Content-Type: application/json; charset=utf-8');
$colissimoApi = new ColissimoApi();
$colissimoApi->run();
```
Create a ```temp/``` folder that will be used to store colissimo pages and give it read/write permission.

##### With git clone
```php
<?php
use ColissimoApi\ColissimoApi;

require 'ColissimoApi/ColissimoApi.php';

header('Content-Type: application/json; charset=utf-8');
$colissimoApi = new ColissimoApi();
$colissimoApi->run();
```

Give read/write permission to the ```temp/``` folder.

##### With both
Go to ht&#8203;tp://</span>example.com/?id={{here a valid colissimo id}}

It should return json encoded data like this:
```json
{"id":"9V01144106931","destination":"NICE","0":{"date":"01\/07\/2015","label":"Votre colis est livr\u00e9.","location":"Centre Courrier 06"},"1":{"date":"01\/07\/2015","label":"Votre colis est arriv\u00e9 sur son site de distribution","location":"Centre Courrier 06"},"2":{"date":"30\/06\/2015","label":"Votre colis est en cours d'acheminement.","location":"Plate-forme Midi-Pyr\u00e9n\u00e9es"},"3":{"date":"29\/06\/2015","label":"Votre colis est pr\u00eat \u00e0 \u00eatre exp\u00e9di\u00e9, il va \u00eatre remis \u00e0 La Poste.","location":""}}
```

![](https://cloud.githubusercontent.com/assets/5358048/8503827/e3c2126a-21c5-11e5-8e41-7140ade2e1a5.png)
