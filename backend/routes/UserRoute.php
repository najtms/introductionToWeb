<?php
require_once __DIR__ . '/../services/UserService.php';
require_once __DIR__ . '/../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;



Flight::set('user_service', new UserService());
////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Get(
 *     path="/user/{email}",
 *     summary="Get user by email",
 *     tags={"User"},
 *     security={
 *         {"bearerAuth": {}}
 *     },
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
    Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);

    try {
        $user = Flight::get('user');

        if ($user->role === Roles::ADMIN) {
            $result = Flight::get('user_service')->getByEmail($email);
        } else {
            $result = Flight::get('user_service')->get_user_by_email_user($email);
        }

        Flight::json($result);
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
 *     security={
 *         {"bearerAuth": {}}
 *     },
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
 *     security={
 *         {"bearerAuth": {}}
 *     },
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
    Flight::auth_middleware()->authorizeRole(Roles::USER);
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
 *     security={
 *         {"bearerAuth": {}}
 *     },
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
    Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
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
 *     security={
 *         {"bearerAuth": {}}
 *     },
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
    Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
    try {
        $result = Flight::get('user_service')->DeleteUser($email);
        Flight::json(["message" => "User deleted", "result" => $result]);
    } catch (Exception $e) {
        Flight::json(["error" => $e->getMessage()], 400);
    }
});
/**
 * @OA\Get(
 *     path="/user",
 *     summary="Get authenticated user information",
 *     tags={"User"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="User information retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="User retrieved successfully"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="email", type="string", example="example@example.com"),
 *                 @OA\Property(property="name", type="string", example="John Doe")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error"
 *     )
 * )
 */
Flight::route('GET /user', function () {
    $authHeader = Flight::request()->getHeader('Authorization');
    if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        Flight::halt(401, 'Missing or invalid Authorization header');
    }
    $token = $matches[1];
    Flight::auth_middleware()->verifyToken($token);

    Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);

    $user = Flight::get('user');
    $userId = $user->user_id;
    if ($user->role === Roles::ADMIN) {
        $response = Flight::get('user_service')->getById($userId);
    }else {
        $response = Flight::get('user_service')->get_user_by_email_user($user->email);
    }

    if ($response) {
        Flight::json([
            'message' => 'User retrieved successfully',
            'data' => $response
        ]);
    } else {
        Flight::halt(404, 'User data not found in database.');
    }
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////