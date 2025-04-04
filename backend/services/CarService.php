<?php
require_once __DIR__ . "/BaseService.php";
require_once __DIR__ . "/../dao/CarDAO.php";

class CarService extends BaseService
{
    protected $dao;

    public function __construct()
    {
        $this->dao = new CarDAO();
        parent::__construct($this->dao);
    }
}
