<?php
require_once __DIR__ . "/BaseService.php";
require_once __DIR__ . "/../dao/PaymentDAO.php";

class PaymentService extends BaseService
{
    protected $dao;

    public function __construct()
    {
        $this->dao = new PaymentDAO();
        parent::__construct($this->dao);
    }
    public function createPayment($date, $currency, $amount, $payment_status, $booking_id)
    {
        if (!in_array(strtoupper($currency), ["USD", "EUR", "GBP", "JPY"])) {
            throw new Exception("Unsupported currency: $currency");
        }

        if (!is_numeric($amount) || $amount <= 0) {
            throw new Exception("Invalid payment amount");
        }

        return $this->dao->createPayment($date, $currency, $amount, $payment_status, $booking_id);
    }

    public function deletePayment($id)
    {
        return $this->dao->deletePayment($id);
    }

    public function changePaymentStatus($payment_id, $new_status)
    {
        return $this->dao->changeStatus($payment_id, $new_status);
    }

    public function updatePayment($payment_id, $date, $currency, $amount, $payment_status, $booking_id)
    {
        return $this->dao->updatePayment($payment_id, $date, $currency, $amount, $payment_status, $booking_id);
    }
}
