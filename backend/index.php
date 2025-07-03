<?php
require './vendor/autoload.php';


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once './vendor/autoload.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

Flight::before('error', function () {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE');
    header('Access-Control-Allow-Headers: Content-Type');
});

//routs
require_once(__DIR__ . '/rest/routes/ExamRoutes.php');

Flight::start();
