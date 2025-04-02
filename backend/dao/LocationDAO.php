<?php

require_once __DIR__ . '/BaseDAO.php';

class LocationDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct("Location");
    }

    public function createLocation($Country, $State, $City, $Street, $Zip)
    {
        $sql = "INSERT INTO Location (Country,`State`,City,Street,Zip) VALUES (:Country,:State,:City,:Street,:Zip)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":Country", $Country);
        $stmt->bindParam(":State", $State);
        $stmt->bindParam(":City", $City);
        $stmt->bindParam(":Street", $Street);
        $stmt->bindParam(":Zip", $Zip);
        return $stmt->execute();
    }

    public function updateLocation($id, $Country, $State, $City, $Street, $Zip)
    {
        $sql = "UPDATE Location 
                    SET `Country` = :Country, 
                        `State` = :State, 
                        `City` = :City, 
                        `Street` = :Street, 
                        `Zip` = :Zip 
                    WHERE location_id = :id";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":Country", $Country);
        $stmt->bindParam(":State", $State);
        $stmt->bindParam(":City", $City);
        $stmt->bindParam(":Street", $Street);
        $stmt->bindParam(":Zip", $Zip);

        $stmt->execute();
    }

    public function zipLocation($Zip)
    {
        $sql = "SELECT * FROM Location WHERE Zip = :Zip";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":Zip", $Zip);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
