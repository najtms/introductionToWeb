<?php

require_once __DIR__ . '/BaseDAO.php';

class PaymentDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct("Payment", "payment_id");
    }

    public function createPayment($date, $currency, $amount, $payment_status, $booking_id)
    {
        $sql = "INSERT INTO Payment(date,currency,amount,payment_status,booking_id) VALUES (:date,:currency,:amount,:payment_status,:booking_id)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":currency", $currency);
        $stmt->bindParam(":amount", $amount);
        $stmt->bindParam(":payment_status", $payment_status);
        $stmt->bindParam(":booking_id", $booking_id);

        return $stmt->execute();
    }

    public function deletePayment($id)
    {
        $sql = "DELETE FROM Payment WHERE payment_id = :payment_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":payment_id", $id);
        return $stmt->execute();
    }

    public function changeStatus($payment_id, $new_status)
    {
        $sql = "UPDATE Payment SET `payment_status` = :new_status WHERE payment_id = :payment_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":payment_id", $payment_id);
        $stmt->bindParam(":new_status", $new_status);
        return $stmt->execute();
    }

    public function updatePayment($payment_id, $date, $currency, $amount, $payment_status, $booking_id)
    {
        $sql = "UPDATE Payment 
        SET `date` = :date, 
            `currency` = :currency, 
            `amount` = :amount, 
            `payment_status` = :payment_status, 
            `booking_id` = :booking_id 
        WHERE payment_id = :payment_id";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":payment_id", $payment_id);
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":currency", $currency);
        $stmt->bindParam(":amount", $amount);
        $stmt->bindParam(":payment_status", $payment_status);
        $stmt->bindParam(":booking_id", $booking_id);

        return $stmt->execute();
    }
}
