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

    public function createLocation($Country, $State, $City, $Street, $Zip)
    {
        if (strlen($Zip) < 5) {
            throw new Exception("Invalid ZIP code");
        }
        return $this->dao->createLocation($Country, $State, $City, $Street, $Zip);
    }

    public function updateLocation($id, $Country, $State, $City, $Street, $Zip)
    {
        if (strlen($Zip) < 5) {
            throw new Exception("Invalid ZIP code");
        }
        return $this->dao->updateLocation($id, $Country, $State, $City, $Street, $Zip);
    }

    public function getByZip($Zip)
    {
        return $this->dao->zipLocation($Zip);
    }
}
