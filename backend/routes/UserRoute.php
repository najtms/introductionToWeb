<?php
require_once __DIR__ . '/../services/UserService.php';

Flight::set('user_service', new UserService());
////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Get(
 *     path="/user/{email}",
 *     summary="Get user by email",
 *     tags={"User"},
 *     @OA\Parameter(
 *         name="email",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string", example="example@example.com")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User retrieved"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error retrieving user"
 *     )
 * )
 */

Flight::route('GET /user/@email', function ($email) {
    try {
        $user = Flight::get('user_service')->getByEmail($email);
        Flight::json($user);
    } catch (Exception $e) {
        Flight::json(["error" => $e->getMessage()], 400);
    }
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Post(
 *     path="/user/verify",
 *     summary="Verify user login credentials",
 *     tags={"User"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="email", type="string", example="example@example.com"),
 *             @OA\Property(property="password", type="string", example="yourPassword")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Verification successful"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Invalid credentials"
 *     )
 * )
 */

Flight::route('POST /user/verify', function () {
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::get('user_service')->verifyPassword($data['email'], $data['password']);
        Flight::json(["success" => $result]);
    } catch (Exception $e) {
        Flight::json(["error" => $e->getMessage()], 401);
    }
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Post(
 *     path="/user/create",
 *     summary="Create a new user account",
 *     tags={"User"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="email", type="string", example="example@example.com"),
 *             @OA\Property(property="password", type="string", example="yourPassword")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Account created"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error creating account"
 *     )
 * )
 */

Flight::route('POST /user/create', function () {
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::get('user_service')->CreatingAccount($data['email'], $data['password']);
        Flight::json(["message" => "Account created", "result" => $result]);
    } catch (Exception $e) {
        Flight::json(["error" => $e->getMessage()], 400);
    }
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Put(
 *     path="/user/edit",
 *     summary="Edit an existing user",
 *     tags={"User"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="User_id", type="integer", example=1),
 *             @OA\Property(property="FirstName", type="string", example="John"),
 *             @OA\Property(property="LastName", type="string", example="Doe"),
 *             @OA\Property(property="Phone", type="string", example="+123456789"),
 *             @OA\Property(property="DriverLicence", type="string", example="B1234567")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error updating user"
 *     )
 * )
 */

Flight::route('PUT /user/edit', function () {
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::get('user_service')->UserEdit(
            $data['User_id'],
            $data['FirstName'],
            $data['LastName'],
            $data['Phone'],
            $data['DriverLicence']
        );
        Flight::json(["message" => "User updated", "result" => $result]);
    } catch (Exception $e) {
        Flight::json(["error" => $e->getMessage()], 400);
    }
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Delete(
 *     path="/user/{email}",
 *     summary="Delete a user by email",
 *     tags={"User"},
 *     @OA\Parameter(
 *         name="email",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string", example="example@example.com")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error deleting user"
 *     )
 * )
 */

Flight::route('DELETE /user/@email', function ($email) {
    try {
        $result = Flight::get('user_service')->DeleteUser($email);
        Flight::json(["message" => "User deleted", "result" => $result]);
    } catch (Exception $e) {
        Flight::json(["error" => $e->getMessage()], 400);
    }
});
////////////////////////////////////////////////////////////////////////////////////////////////////////////