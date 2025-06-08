<?php

require './vendor/autoload.php';

require __DIR__ . '/services/AuthService.php';
require "./middleware/AuthMiddleware.php";


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::before('error', function () {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE');
    header('Access-Control-Allow-Headers: Content-Type');
});

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

Flight::register('auth_service', 'AuthService');
Flight::register('auth_middleware', "AuthMiddleware");

Flight::route('/*', function () {
    $url = Flight::request()->url;
    error_log("Requested URL: " . $url);
    if (
        strpos($url, '/auth/login') === 0 ||
        strpos($url, '/auth/register') === 0 ||
        strpos($url, '/car/carTypeThree') === 0 ||
        strpos($url, '/car/carTypeAll') === 0  ||
        strpos($url, '/car/randomThree') === 0
        ) {
        return TRUE;
    } else {
        try {
            $headers = getallheaders();
            $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : null;


            // DEBUG: check raw header
            error_log("Authorization Header: " . var_export($authHeader, true));

            // Extract token using regex
            if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                Flight::halt(401, "Missing or malformed Authorization header");
            }

            $token = $matches[1];
            Flight::auth_middleware()->verifyToken($token);
            return TRUE;
        } catch (\Exception $e) {
            Flight::halt(401, $e->getMessage());
        }
    }
});

// Load routes
require_once __DIR__ . '/routes/AuthRoute.php';
require_once __DIR__ . '/routes/UserRoute.php';
require_once __DIR__ . '/routes/PaymentRoute.php';
require_once __DIR__ . '/routes/BookingRoute.php';
require_once __DIR__ . '/routes/CarRoute.php';
require_once __DIR__ . '/routes/FormRoute.php';

Flight::start();
