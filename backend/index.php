<?php

require './vendor/autoload.php';
require_once __DIR__ . '/routes/UserRoute.php';
require_once __DIR__ . '/routes/PaymentRoute.php';
require_once __DIR__ . '/routes/BookingRoute.php';
require_once __DIR__ . '/routes/CarRoute.php';
require_once __DIR__ . '/routes/LocationRoute.php';




Flight::route('/', function () {
    echo 'hello world!';
});

Flight::route('/json', function () {
    Flight::json(['hello' => 'world']);
});

Flight::start();
