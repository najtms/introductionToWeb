<?php

require_once __DIR__ . '/BaseDAO.php';

class CarDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct("Cars");
    }
    //Mainly backend for Admins to add new cars to the system
    public function creatingCar(
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
        $sql = "INSERT INTO Cars(Brand,Model,Year,License_plate,availablity_status,engine,kilometers
        ,fueltype,transmissions,seats,cartype,imgurl) VALUES (:Brand,:Model,:Year,:License_plate,:availablity_status,:engine,:kilometers
        ,:fueltype,:transmissions,:seats,:cartype,:imgur)";

        $stmt = $this->connection->prepare($sql);
        $stmt->BindParam(":Brand", $Brand);
        $stmt->BindParam(":Model", $Model);
        $stmt->BindParam(":Year", $Year);
        $stmt->BindParam(":License_plate", $License_plate);
        $stmt->BindParam(":availablity_status", $availablity_status);
        $stmt->BindParam(":engine", $engine);
        $stmt->BindParam(":kilometers", $kilometers);
        $stmt->BindParam(":fueltype", $fueltype);
        $stmt->BindParam(":transmissions", $transmissions);
        $stmt->BindParam(":seats", $seats);
        $stmt->BindParam(":cartype", $cartype);
        $stmt->BindParam(":imgur", $imgurl);

        return $stmt->execute();
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
        $sql = "UPDATE Cars SET 
                    Brand = :Brand, 
                    Model = :Model, 
                    Year = :Year, 
                    License_plate = :License_plate, 
                    availablity_status = :availablity_status, 
                    engine = :engine, 
                    kilometers = :kilometers, 
                    fueltype = :fueltype, 
                    transmissions = :transmissions, 
                    seats = :seats, 
                    cartype = :cartype, 
                    imgurl = :imgurl 
                WHERE car_id = :car_id";

        $stmt = $this->connection->prepare($sql);
        $stmt->BindParam(":car_id", $car_id);
        $stmt->BindParam(":Brand", $Brand);
        $stmt->BindParam(":Model", $Model);
        $stmt->BindParam(":Year", $Year);
        $stmt->BindParam(":License_plate", $License_plate);
        $stmt->BindParam(":availablity_status", $availablity_status);
        $stmt->BindParam(":engine", $engine);
        $stmt->BindParam(":kilometers", $kilometers);
        $stmt->BindParam(":fueltype", $fueltype);
        $stmt->BindParam(":transmissions", $transmissions);
        $stmt->BindParam(":seats", $seats);
        $stmt->BindParam(":cartype", $cartype);
        $stmt->BindParam(":imgurl", $imgurl);

        return $stmt->execute();
    }


    public function changingReg($car_id, $reg)
    {
        $sql = "UPDATE Cars SET License_plate = :License_plate WHERE car_id = :car_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->BindParam(":car_id", $car_id);
        $stmt->BindParam(":License_plate", $reg);
        $stmt->execute();
    }

    public function getAllByBrand($Brand)
    {
        $sql = "SELECT * FROM Cars WHERE Brand = :Brand";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":Brand", $Brand);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
