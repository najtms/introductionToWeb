<?php
require_once __DIR__ . '/../services/BookingService.php';

Flight::set('bookingService', new BookingService());
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Post(
 *     path="/booking",
 *     summary="Create a new booking",
 *     tags={"Booking"},
 *  security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"start_date", "end_date", "price", "user_id", "fk_location_id", "fk_payment", "fk_car_id"},
 *             @OA\Property(property="start_date", type="string", format="date"),
 *             @OA\Property(property="end_date", type="string", format="date"),
 *             @OA\Property(property="price", type="number", format="float"),
 *             @OA\Property(property="user_id", type="integer"),
 *             @OA\Property(property="fk_location_id", type="integer"),
 *             @OA\Property(property="fk_payment", type="integer"),
 *             @OA\Property(property="fk_car_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Booking created successfully"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input"
 *     )
 * )
 */

Flight::route('POST /booking', function () {
    Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('bookingService')->createBooking(
        $data['start_date'],
        $data['end_date'],
        $data['price'],
        $data['user_id'],
        $data['fk_location_id'],
        $data['fk_payment'],
        $data['fk_car_id']
    ));
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Get(
 *     path="/booking/{id}",
 *     summary="Get booking by ID",
 *     tags={"Booking"},
 *  security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Booking retrieved successfully"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Booking not found"
 *     )
 * )
 */


Flight::route('GET /booking/@id', function ($id) {
    Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
    Flight::json(Flight::get('bookingService')->getBookingById($id));
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Put(
 *     path="/booking/{id}",
 *     summary="Update an existing booking",
 *     tags={"Booking"},
 *  security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"start_date", "end_date", "price", "user_id", "fk_location_id", "fk_payment", "fk_car_id"},
 *             @OA\Property(property="start_date", type="string", format="date"),
 *             @OA\Property(property="end_date", type="string", format="date"),
 *             @OA\Property(property="price", type="number", format="float"),
 *             @OA\Property(property="user_id", type="integer"),
 *             @OA\Property(property="fk_location_id", type="integer"),
 *             @OA\Property(property="fk_payment", type="integer"),
 *             @OA\Property(property="fk_car_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Booking updated successfully"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input"
 *     )
 * )
 */

Flight::route('PUT /booking/@id', function ($id) {
    Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('bookingService')->updateBooking(
        $id,
        $data['start_date'],
        $data['end_date'],
        $data['price'],
        $data['user_id'],
        $data['fk_location_id'],
        $data['fk_payment'],
        $data['fk_car_id']
    ));
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Delete(
 *     path="/booking/{id}",
 *     summary="Delete a booking by ID",
 *     tags={"Booking"},
 *  security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Booking deleted successfully"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Booking not found"
 *     )
 * )
 */


Flight::route('DELETE /booking/@id', function ($id) {
    Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
    Flight::json(Flight::get('bookingService')->deleteBooking($id));
});
