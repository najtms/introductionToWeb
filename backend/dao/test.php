<?php

//DAO
require_once "../dao/UserDAO.php";
require_once "../dao/PaymentDAO.php";
require_once "../dao/LocationDAO.php";
require_once "../dao/BookingDAO.php";
require_once "../dao/CarDAO.php";


//Service
require_once "../services/UserService.php";
require_once "../services/BookingService.php";
require_once "../services/CarService.php";
require_once "../services/PaymentService.php";
require_once "../services/LocationService.php";



$userDAO = new UserDAO();
$userService = new UserService();

//DAOs
//$result = $userDAO->getByEmail("test@ibu.edu.ba");
//$result = $userDAO->verifyPassword("test@ibu.edu.ba", "r");
//$result = $userDAO->CreatingAccount("esdsdsmail@ow.com", "fitone");
//$result = $userDAO->UserEdit(4, "Rafa", "Jafa", "03322102", "HDISAFI3");
//$result = $userDAO->DeleteUser("test@ibu.edu.ba);

//Inhereted functions work aswell Insert,GetAll,GetByID,Insert,updat and delete
// All DAOS and Services inherit it.

//Service [-DONE-][Lab]

//$result = $userService->getByEmail("test@bu.edu.ba");
//$result = $userService->verifyPassword("test@ibu.edu.ba", "r");
//$result = $userService->CreatingAccount("email@ow.com", "fitone");
//$result = $userService->UserEdit(4, "Rafa", "Jafa", "03322102", "HDISAFI3");
//$result = $userService->DeleteUser("test@ibu.edu.ba);


// UserDao-UserService

//BookingDAO
$BookingDAO = new BookingDAO();
//$BookingService = new BookingService();

//$result = $BookingDAO->createBooking('2025-03-01', '2025-03-02', 100.5, null, null, null, null);
//$result = $BookingDAO->getBookingById(2);
//$result = $BookingDAO->getAllBookings();
//$result = $BookingDAO->updateBooking(2, '2025-03-02', '2025-03-06', 120.00, null, null, null, null);
//$result = $BookingDAO->deleteBooking(1);

//BookingService [-TODO-]

//$result = $BookingService->createBooking(TODO);
//$result = $BookingService->getBookingById(TODO);
//$result = $BookingService->getAllBookings(TODO);
//$result = $BookingService->updateBooking(TODO);
//$result = $BookingService->deleteBooking(TODO);

//CarDAO
$CarDAO = new CarDAO();
//$CarService = new CarService();

//$result = $CarDAO->creatingCar("Toyota", "Corolla", 2021, "ABC1234", true, "Hybrid", "5000", "Petrol", "Automatic", 4, "Sedan", "empty");
//$result = $CarDAO->updateCar(1,"Toyota", "Corolla", 2021, "ABC1234", true, "Hybrid", "5000", "Petrol", "Automatic", 4, "Sedan", "empty");
//$result = $CarDAO->GetByID(1);
//$result = $CarDAO->changingReg(1, "120ksow");
//$result = $CarDAO->delete(1);
//$result = $CarDAO->getAll();
//$result = $CarDAO->getAllByBrand("Audi");

//CarService [-TODO-]

//$result = $CarService->creatingCar(TODO);
//$result = $CarService->updateCar(TODO);
//$result = $CarService->GetByID(TODO);
//$result = $CarService->changingReg(TODO);
//$result = $CarService->getAllByBrand(TODO);

$PaymentDAO = new PaymentDAO();
//$PaymentService = new PaymentService();

//DAO

//$result = $PaymentDAO->createPayment('2025-03-31', 'USD', 100.50, 'Pending', 1);
//$result = $PaymentDAO->deletePayment(1);
//$result = $PaymentDAO->changeStatus(2, "Payed");
//$result = $PaymentDAO->updatePayment(2, '2025-03-31', 'EURO', 100.50, 'Lst', 2);

//Service [-TODO-]

//$result = $PaymentService->createPayment(TODO);
//$result = $PaymentService->deletePayment(TODO);
//$result = $PaymentService->changeStatus(TODO);
//$result = $PaymentService->updatePayment(TODO);


$LocationDAO = new LocationDAO();
//$LocationService = new LocationService();

//DAO

//$result = $LocationDAO->createLocation("Bosnia and Herzegovina", "Kanton Sarajevo", "Sarajevo", "Ivo Andric br 2", "71000");
//$result = $LocationDAO->updateLocation(1, "Qatar", "//", "Doha", "Al-Hitmi 21", "Q192");
//$result = $LocationDAO->zipLocation("Q192");

//Service [-TODO-]

//$result = $LocationService->createLocation();
//$result = $LocationService->updateLocation();
//$result = $LocationService->zipLocation():







var_dump($result);
