<?php
require_once __DIR__ . "/../services/ExamService.php";
Flight::set('exam_service', new ExamService());

/**
 * @OA\Get(
 *     path="/connection-check",
 *     summary="Check API Connection",
 *     tags={"exam"},
 *     @OA\Response(
 *         response=200,
 *         description="Get Connection Check",
 *     )
 * )
 */
Flight::route('GET /connection-check', function () {
    try {
        $dao = new ExamDao();
        echo "Connection to the database was successful.";
    } catch (Exception $e) {
        echo "Connection failed: " . $e->getMessage();
    }
});


/**
 * @OA\Get(
 * path="/customers",
 * summary="Get All Customers",
 * tags={"exam"},
 * @OA\Response(
 *     response=200,
 *     description="Get Customer by ID",
 *     ),
 * )
 */
Flight::route('GET /customers', function () {
    Flight::json((Flight::get('exam_service'))->get_customers());
});

/**
 * @OA\Get(
 * path="/customer/meals/{customer_id}",
 * summary="Get Customers Meals by ID",
 * tags={"exam"},
 * @OA\Parameter(
 *     name="customer_id",
 *     in="path",
 *     required=true,
 *     description="ID of the customer",
 *     @OA\Schema(type="integer")
 * ),
 * @OA\Response(
 *     response=200,
 *     description="Get Customer by ID",
 *     ),
 * )
 */

Flight::route('GET /customer/meals/@customer_id', function ($customer_id) {
    Flight::json((Flight::get('exam_service'))->get_customer_meals($customer_id));
});

/**
 * @OA\Post(
 * path="/add",
 * summary="Add Customer",
 * tags={"exam"},
 * @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *         type="object",
 *         @OA\Property(property="first_name", type="string"),
 *         @OA\Property(property="last_name", type="string"),
 *         @OA\Property(property="birth_date", type="string", format="date"),
 *         @OA\Property(
 *             property="status",
 *             type="integer",
 *             enum={"1", "2"},
 *             example="1",
 *             description="Status of the customer, 1 for active, 2 for inactive"
 *         ),
 *     )
 * ),
 * @OA\Response(
 *     response=200,
 *     description="Customer added successfully"
 * ),
 * )
 */

Flight::route('POST /add', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('exam_service')->add_customer($data));
});

/**
 * @OA\Get(
 * path="/foods/report",
 * summary="Get Foods Report",
 * tags={"exam"},
 * @OA\Parameter(
 *     name="page",
 *     in="query",
 *     required=false,
 *     description="Page number for pagination",
 *     @OA\Schema(type="integer", default=1)
 * ),
 * @OA\Parameter(
 *     name="limit",
 *     in="query",
 *     required=false,
 *     description="Number of items per page",
 *     @OA\Schema(type="integer", default=10)
 * ),
 * @OA\Response(
 *     response=200,
 *     description="Foods report retrieved successfully"
 * ),
 * )
 */
Flight::route('GET /foods/report', function () {
    try {
        $limit = flight::request()->query['limit'] ?? 10;
        $offset = flight::request()->query['offset'] ?? 0;
        $result = Flight::get('exam_service')->foods_report((int)$limit, (int)$offset);
        Flight::json($result);
    } catch (Exception $e) {
        Flight::json(["error" => $e->getMessage()], 400);
    };
});
