<?php
require_once __DIR__ . '/../services/CarService.php';

Flight::set('carService', new CarService());
Flight::group('/car', function (){
//Creating Car
/**
 * @OA\Post(
 *     path="/car/",
 *     summary="Create a new car",
 *     tags={"Car"},
 *  security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"Brand", "Model", "Year", "License_plate", "availablity_status", "engine", "kilometers", "fueltype", "transmissions", "seats", "cartype", "imgurl"},
 *             @OA\Property(property="Brand", type="string"),
 *             @OA\Property(property="Model", type="string"),
 *             @OA\Property(property="Year", type="integer"),
 *             @OA\Property(property="License_plate", type="string"),
 *             @OA\Property(property="availablity_status", type="integer"),
 *             @OA\Property(property="engine", type="string"),
 *             @OA\Property(property="kilometers", type="integer"),
 *             @OA\Property(property="fueltype", type="string"),
 *             @OA\Property(property="transmissions", type="string"),
 *             @OA\Property(property="seats", type="integer"),
 *             @OA\Property(property="cartype", type="string"),
 *             @OA\Property(property="imgurl", type="string"),
 *             @OA\Property(property="Price", type="number"),
 *             @OA\Property(property="Location", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Car created successfully"
 *     )
 * )
 */

////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Flight::route('POST /', function () {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('carService')->createCar(...array_values($data)));
});

/**
 * @OA\Put(
 *     path="/car/{id}",
 *     summary="Update an existing car",
 *     tags={"Car"},
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
 *             required={"Brand", "Model", "Year", "License_plate", "availablity_status", "engine", "kilometers", "fueltype", "transmissions", "seats", "cartype", "imgurl"},
 *             @OA\Property(property="Brand", type="string"),
 *             @OA\Property(property="Model", type="string"),
 *             @OA\Property(property="Year", type="integer"),
 *             @OA\Property(property="License_plate", type="string"),
 *             @OA\Property(property="availablity_status", type="integer"),
 *             @OA\Property(property="engine", type="string"),
 *             @OA\Property(property="kilometers", type="integer"),
 *             @OA\Property(property="fueltype", type="string"),
 *             @OA\Property(property="transmissions", type="string"),
 *             @OA\Property(property="seats", type="integer"),
 *             @OA\Property(property="cartype", type="string"),
 *             @OA\Property(property="imgurl", type="string", format="uri"),
 *              @OA\Property(property="Price", type="number"),
 *             @OA\Property(property="Location", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Car updated successfully"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */


Flight::route('PUT /@id', function ($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    $carService = Flight::get('carService');
    $result = call_user_func_array([$carService, 'updateCar'], array_merge([$id], array_values($data)));
    Flight::json($result);
});

/////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Put(
 *     path="/car/registration/{id}",
 *     summary="Change a car's registration number",
 *     tags={"Car"},
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
 *             @OA\Property(property="new_reg", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Registration changed"
 *     )
 * )
 */

Flight::route('PUT /registration/@id', function ($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $new_reg = Flight::request()->data['new_reg'];
    Flight::json(Flight::get('carService')->changeRegistration($id, $new_reg));
});
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Get(
 *     path="/car/brand/{brand}",
 *     summary="Get all cars by brand",
 *     tags={"Car"},
 *  security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\Parameter(
 *         name="brand",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of cars by brand"
 *     )
 * )
 */

Flight::route('GET /brand/@brand', function ($brand) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::get('carService')->getAllCarsByBrand($brand));
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Get(
 *     path="/car/carTypeThree",
 *     summary="Get three cars by car type",
 *     tags={"Car"},
 *     security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\Parameter(
 *         name="carType",
 *         in="query",
 *         required=true,
 *         @OA\Schema(type="string"),
 *         description="Car type to filter"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of three cars by car type"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     )
 * )
 */

Flight::route('GET /carTypeThree', function () {

    $carType = Flight::request()->query['carType'] ?? null;
    if (!$carType) {
        Flight::json(['error' => 'carType is required'], 400);
        return;
    }

    Flight::json(Flight::get('carService')->getThreeByCartype($carType));
});
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Get(
 *     path="/car/carTypeAll",
 *     summary="Get all cars by car type",
 *     tags={"Car"},
 *     security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\Parameter(
 *         name="carType",
 *         in="query",
 *         required=false,
 *         @OA\Schema(type="string"),
 *         description="Car type to filter"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of all cars by car type"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     )
 * )
 */

Flight::route('GET /carTypeAll', function () {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);

    $carType = Flight::request()->query['carType'] ?? null;
    if (!$carType) {
        Flight::json(['error' => 'carType is required'], 400);
        return;
    }

    Flight::json(Flight::get('carService')->gettAllCarsByCartype($carType));
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Get(
 *     path="/car/randomThree",
 *     summary="Get three random cars",
 *     tags={"Car"},
 *     @OA\Response(
 *         response=200,
 *         description="List of three random cars"
 *     )
 * )
 */
Flight::route('GET /randomThree', function () {
    Flight::json(Flight::get('carService')->getThreeRandomCars());
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * @OA\Get(
 *     path="/car/",
 *     summary="Get all cars",
 *     tags={"Car"},
 *  security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\Response(
 *         response=200,
 *         description="List of all cars"
 *     )
 * )
 */

Flight::route('GET /', function () {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::get('carService')->getAllCars());
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Delete(
 *     path="/car/{id}",
 *     summary="Delete a car by ID",
 *     tags={"Car"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Car deleted successfully"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Car not found"
 *     )
 * )
 */
Flight::route('DELETE /@id', function($car_id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $result = Flight::get('carService')->deleteByID($car_id);
    Flight::json(['success' => $result]);
});
});