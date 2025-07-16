<?php
require "./dao/ExamDao.php";

require "../vendor/autoload.php";
require "./services/ExamService.php";

Flight::set('examService', new ExamService());
require './routes/ExamRoutes.php';

Flight::start();
