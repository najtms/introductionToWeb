<?php
require_once __DIR__ . '/../services/PaymentService.php';

Flight::set('paymentService', new PaymentService());
////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Post(
 *     path="/payment",
 *     summary="Create a new payment",
 *     tags={"Payment"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="date", type="string", format="date", example="2025-04-13"),
 *             @OA\Property(property="currency", type="string", example="BAM"),
 *             @OA\Property(property="amount", type="number", format="float", example=100.50),
 *             @OA\Property(property="payment_status", type="string", example="pending"),
 *             @OA\Property(property="booking_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Payment created successfully"
 *     )
 * )
 */

Flight::route('POST /payment', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('paymentService')->createPayment(
        $data['date'],
        $data['currency'],
        $data['amount'],
        $data['payment_status'],
        $data['booking_id']
    ));
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Put(
 *     path="/payment/{id}",
 *     summary="Update an existing payment",
 *     tags={"Payment"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="date", type="string", format="date", example="2025-04-13"),
 *             @OA\Property(property="currency", type="string", example="BAM"),
 *             @OA\Property(property="amount", type="number", format="float", example=100.50),
 *             @OA\Property(property="payment_status", type="string", example="completed"),
 *             @OA\Property(property="booking_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Payment updated successfully"
 *     )
 * )
 */

Flight::route('PUT /payment/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('paymentService')->updatePayment(
        $id,
        $data['date'],
        $data['currency'],
        $data['amount'],
        $data['payment_status'],
        $data['booking_id']
    ));
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Delete(
 *     path="/payment/{id}",
 *     summary="Delete a payment by ID",
 *     tags={"Payment"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Payment deleted successfully"
 *     )
 * )
 */

Flight::route('DELETE /payment/@id', function ($id) {
    Flight::json(Flight::get('paymentService')->deletePayment($id));
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Patch(
 *     path="/payment/status/{id}",
 *     summary="Update payment status",
 *     tags={"Payment"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="new_status", type="string", example="completed")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Payment status updated successfully"
 *     )
 * )
 */

Flight::route('PATCH /payment/status/@id', function ($id) {
    $new_status = Flight::request()->data['new_status'];
    Flight::json(Flight::get('paymentService')->changePaymentStatus($id, $new_status));
});
////////////////////////////////////////////////////////////////////////////////////////////////////////////    