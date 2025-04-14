<?php
require_once __DIR__ . "/BaseService.php";
require_once __DIR__ . "/../dao/BookingDAO.php";

class BookingService extends BaseService
{
    protected $dao;

    public function __construct()
    {
        $this->dao = new BookingDAO();
        parent::__construct($this->dao);
    }
    //Checks if end date is before start date
    public function createBooking($start_date, $end_date, $price, $user_id, $fk_location_id, $fk_payment, $fk_car_id)
    {
        if (strtotime($end_date) <= strtotime($start_date)) {
            throw new Exception("End date must be after start date");
        }

        if ($price <= 0) {
            throw new Exception("Price must be a positive value");
        }

        return $this->dao->createBooking($start_date, $end_date, $price, $user_id, $fk_location_id, $fk_payment, $fk_car_id);
    }

    public function getBookingById($id)
    {
        $booking = $this->dao->getBookingById($id);
        if (!$booking) {
            throw new Exception("Booking not found");
        }
        return $booking;
    }

    public function updateBooking($booking_id, $start_date, $end_date, $price, $user_id, $fk_location_id, $fk_payment, $fk_car_id)
    {
        if (strtotime($end_date) <= strtotime($start_date)) {
            throw new Exception("End date must be after start date");
        }

        if ($price <= 0) {
            throw new Exception("Price must be a positive value");
        }

        return $this->dao->updateBooking($booking_id, $start_date, $end_date, $price, $user_id, $fk_location_id, $fk_payment, $fk_car_id);
    }

    public function deleteBooking($booking_id)
    {
        return $this->dao->deleteBooking($booking_id);
    }
}
