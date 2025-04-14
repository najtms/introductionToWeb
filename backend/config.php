<?php
class Database
{
    private static $host = '127.0.0.1'; //Localhost doesn't work it breaks POSTMAN
    private static $dbName = 'car_rental_mysql';
    private static $username = 'root';
    private static $password = 'root';
    private static $connection = null;


    public static function connect()
    {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    "mysql:host=" . self::$host . ";port=3306;dbname=" . self::$dbName, // Specify port here
                    self::$username,
                    self::$password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
