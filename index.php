<?php
use ColissimoApi\ColissimoApi;

header('Content-Type: application/json');
require 'ColissimoApi/ColissimoApi.php';
$colissimoApi = new ColissimoApi();
$colissimoApi->run();