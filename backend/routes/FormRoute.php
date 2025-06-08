<?php
require_once __DIR__ . '/../services/FormService.php';

Flight::set('formService', new FormService());

/**
 * @OA\Post(
 *     path="/form/create",
 *     summary="Create a new form entry",
 *     tags={"Form"},
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="FullName", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="phone", type="string", example="+38761123456"),
 *             @OA\Property(property="Message", type="string", example="Hello, this is a message."),
 *             @OA\Property(property="Status", type="string", example="pending")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Form created"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error creating form"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/form/all",
 *     summary="Get all forms",
 *     tags={"Form"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of forms"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Unauthorized"
 *     )
 * )
 */

/**
 * @OA\Put(
 *     path="/form/status/{form_id}",
 *     summary="Change status of a form",
 *     tags={"Form"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="form_id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="Status", type="string", example="approved")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Status updated"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error updating status"
 *     )
 * )
 */

Flight::group('/form', function () {
    Flight::route('POST /create', function () {
        // Allow both USER and ADMIN to create forms
        Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
        $data = Flight::request()->data->getData();
        $result = Flight::get('formService')->createForm($data);
        Flight::json($result);
    });

    Flight::route('GET /all', function () {
        Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
        $result = Flight::get('formService')->getAllForms();
        Flight::json($result);
    });

    Flight::route('PUT /status/@form_id', function ($form_id) {
        Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
        $data = Flight::request()->data->getData();
        $status = isset($data['Status']) ? $data['Status'] : null;
        if ($status === null) {
            Flight::json(['error' => 'Status is required'], 400);
            return;
        }
        $result = Flight::get('formService')->changeStatus($form_id, $status);
        Flight::json($result);
    });
});