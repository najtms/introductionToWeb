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
}
