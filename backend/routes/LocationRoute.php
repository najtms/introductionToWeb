<?php
require_once __DIR__ . '/../services/LocationService.php';

Flight::set('locationService', new LocationService());
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Post(
 *     path="/location",
 *     summary="Create a new location",
 *     tags={"Location"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="Country", type="string", example="Bosnia and Herzegovina"),
 *             @OA\Property(property="State", type="string", example="Federation"),
 *             @OA\Property(property="City", type="string", example="Sarajevo"),
 *             @OA\Property(property="Street", type="string", example="Zmaja od Bosne"),
 *             @OA\Property(property="Zip", type="string", example="71000")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Location created successfully"
 *     )
 * )
 */

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



Flight::route('POST /location', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('locationService')->createLocation(
        $data['Country'],
        $data['State'],
        $data['City'],
        $data['Street'],
        $data['Zip']
    ));
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Put(
 *     path="/location/{id}",
 *     summary="Update a location",
 *     tags={"Location"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="Country", type="string", example="Bosnia and Herzegovina"),
 *             @OA\Property(property="State", type="string", example="Federation"),
 *             @OA\Property(property="City", type="string", example="Sarajevo"),
 *             @OA\Property(property="Street", type="string", example="Zmaja od Bosne"),
 *             @OA\Property(property="Zip", type="string", example="71000")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Location updated successfully"
 *     )
 * )
 */


Flight::route('PUT /location/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('locationService')->updateLocation(
        $id,
        $data['Country'],
        $data['State'],
        $data['City'],
        $data['Street'],
        $data['Zip']
    ));
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * @OA\Get(
 *     path="/location/zip/{zip}",
 *     summary="Get location by ZIP",
 *     tags={"Location"},
 *     @OA\Parameter(
 *         name="zip",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns location info for the given ZIP"
 *     )
 * )
 */

Flight::route('GET /location/zip/@zip', function ($zip) {
    Flight::json(Flight::get('locationService')->getByZip($zip));
});
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////