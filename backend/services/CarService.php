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

    public function createCar(
        $Brand,
        $Model,
        $Year,
        $License_plate,
        $availablity_status,
        $engine,
        $kilometers,
        $fueltype,
        $transmissions,
        $seats,
        $cartype,
        $imgurl
    ) {
        if ($Year < 1886 || $Year > date("Y")) {
            throw new Exception("Invalid car year");
        }

        if (!in_array($fueltype, ["Petrol", "Diesel", "Electric", "Hybrid"])) {
            throw new Exception("Invalid fuel type");
        }

        if (!in_array($transmissions, ["Manual", "Automatic"])) {
            throw new Exception("Invalid transmission type");
        }

        return $this->dao->creatingCar(
            $Brand,
            $Model,
            $Year,
            $License_plate,
            $availablity_status,
            $engine,
            $kilometers,
            $fueltype,
            $transmissions,
            $seats,
            $cartype,
            $imgurl
        );
    }

    public function updateCar(
        $car_id,
        $Brand,
        $Model,
        $Year,
        $License_plate,
        $availablity_status,
        $engine,
        $kilometers,
        $fueltype,
        $transmissions,
        $seats,
        $cartype,
        $imgurl
    ) {
        return $this->dao->updateCar(
            $car_id,
            $Brand,
            $Model,
            $Year,
            $License_plate,
            $availablity_status,
            $engine,
            $kilometers,
            $fueltype,
            $transmissions,
            $seats,
            $cartype,
            $imgurl
        );
    }

    public function changeRegistration($car_id, $new_reg)
    {
        return $this->dao->changingReg($car_id, $new_reg);
    }

    public function getAllCarsByBrand($Brand)
    {
        return $this->dao->getAllByBrand($Brand);
    }
}
