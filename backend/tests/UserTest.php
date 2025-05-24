<?php

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function setUp(): void
    {
        require_once __DIR__ . '/../vendor/autoload.php';
        require_once __DIR__ . '/../index.php';
        Flight::halt(false);  // this is used to prevent auto-exit during test
        Flight::start();  // here we need to start the app

    }

    public function testGetAllUsers()
    {
        $validToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjp7ImVtYWlsIjoibXVoYW1hZC5hLi5zc2FhZEBzdHUuaWJ1LmVkdS5iYSIsInJvbGUiOiJVU0VSIn0sImlhdCI6MTc0NjQ1NzM0NiwiZXhwIjoxNzQ2NTQzNzQ2LCJyb2xlIjoiVVNFUiJ9.efKAJsIss3noWqfMwwoW6dMOXfQdWBMAOdy4ynn10oY";

        $_SERVER['HTTP_AUTHORIZATION'] = 'Bearer ' . $validToken;
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/user';

        ob_start();
        Flight::start();
        $output = ob_get_clean();
        $this->assertEquals(200, http_response_code());
        $this->assertJson($output);
    }
}
