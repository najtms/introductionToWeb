<?php
require_once __DIR__ . "/BaseService.php";
require_once __DIR__ . "/../dao/LocationDAO.php";

class LocationService extends BaseService
{
    protected $dao;

    public function __construct()
    {
        $this->dao = new LocationDAO();
        parent::__construct($this->dao);
    }
}
