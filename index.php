<?php
use ColissimoApi\ColissimoApi;

header('Content-Type: application/json; charset=utf-8');
require 'ColissimoApi/ColissimoApi.php';
$colissimoApi = new ColissimoApi();
$colissimoApi->run();