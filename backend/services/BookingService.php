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
}
