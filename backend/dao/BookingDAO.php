<?php

require_once __DIR__ . '/BaseDAO.php';

class BookingDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct("Booking");
    }

    public function createBooking($start_date, $end_date, $price, $user_id, $fk_location_id, $fk_payment, $fk_car_id)
    {
        $sql = "INSERT INTO Booking (start_date, end_date, price, user_id, fk_location_id, fk_payment, fk_car_id) 
                VALUES (:start_date, :end_date, :price, :user_id, :fk_location_id, :fk_payment, :fk_car_id)";
        $stmt = $this->connection->prepare($sql);

        $stmt->bindParam(":start_date", $start_date);
        $stmt->bindParam(":end_date", $end_date);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":fk_location_id", $fk_location_id);
        $stmt->bindParam(":fk_payment", $fk_payment);
        $stmt->bindParam(":fk_car_id", $fk_car_id);

        return $stmt->execute();
    }


    public function getBookingById($id)
    {
        $sql = "SELECT * FROM Booking WHERE booking_id = :id";
        $stmt = $this->connection->prepare($sql);

        $stmt->bindParam(":id", $id);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllBookings()
    {
        $sql = "SELECT * FROM Booking";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateBooking($booking_id, $start_date, $end_date, $price, $user_id, $fk_location_id, $fk_payment, $fk_car_id)
    {
        $sql = "UPDATE Booking 
                SET start_date = :start_date, end_date = :end_date, price = :price, 
                    user_id = :user_id, fk_location_id = :fk_location_id, 
                    fk_payment = :fk_payment, fk_car_id = :fk_car_id 
                WHERE booking_id = :booking_id";

        $stmt = $this->connection->prepare($sql);

        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':fk_location_id', $fk_location_id);
        $stmt->bindParam(':fk_payment', $fk_payment);
        $stmt->bindParam(':fk_car_id', $fk_car_id);
        $stmt->bindParam(':booking_id', $booking_id);

        return $stmt->execute();
    }

    public function deleteBooking($booking_id)
    {
        $sql = "DELETE FROM Booking WHERE booking_id = :booking_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':booking_id', $booking_id);
        return $stmt->execute();
    }
}
