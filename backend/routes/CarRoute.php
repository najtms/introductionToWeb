<?php
require_once __DIR__ . '/../services/CarService.php';

Flight::set('carService', new CarService());
//Creating Car
/**
 * @OA\Post(
 *     path="/car",
 *     summary="Create a new car",
 *     tags={"Car"},
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
 *             @OA\Property(property="imgurl", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Car created successfully"
 *     )
 * )
 */

Flight::route('POST /car', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('carService')->createCar(...array_values($data)));
});
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Put(
 *     path="/car/{id}",
 *     summary="Update an existing car",
 *     tags={"Car"},
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
 *             @OA\Property(property="imgurl", type="string", format="uri")
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


Flight::route('PUT /car/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('carService')->updateCar($id, ...array_values($data)));
});
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Put(
 *     path="/car/registration/{id}",
 *     summary="Change a car's registration number",
 *     tags={"Car"},
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

Flight::route('PUT /car/registration/@id', function ($id) {
    $new_reg = Flight::request()->data['new_reg'];
    Flight::json(Flight::get('carService')->changeRegistration($id, $new_reg));
});
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Get(
 *     path="/car/brand/{brand}",
 *     summary="Get all cars by brand",
 *     tags={"Car"},
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

Flight::route('GET /car/brand/@brand', function ($brand) {
    Flight::json(Flight::get('carService')->getAllCarsByBrand($brand));
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
