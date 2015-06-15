<?php
// php -S 127.0.0.1:8000 -t .

require_once('vendor/autoload.php');

// Initialize Custom API Framework.
$api = new api\Api(); 

// Initialize Controllers.
$mmmr = new api\Controllers\MMMRController();

// Define all of your routes here!
// API->setRoute accepts (/route, array(class, method), HTTP_REQUEST_TYPE)
$api->setRoute('/mmmr', array($mmmr,'MMMRapi'), 'POST');
$api->dispatch();