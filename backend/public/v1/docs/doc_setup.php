<?php

use OpenApi\Attributes as OA;

/**
 * @OA\Info(
 *     title="Introduction to Web",
 *     description="Final Exam",
 *     version="1.0",
 *     @OA\Contact(
 *         email="muhamad.assaad@stu.ibu.edu.ba",
 *         name="Muhamad Assaad"
 *     )
 * ),
 * @OA\Server(
 *     url="http://localhost:8888/TFinal/backend/",
 *     description="API server"
 * ),
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */


class OpenApiSetup {}
