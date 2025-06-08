<?php

require_once __DIR__ . '/BaseDAO.php';

class UserDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct("User", "user_id");
    }
    // Get Email All using Email
    public function getByEmail($email)
    {
        $stmt = $this->connection->prepare("SELECT * FROM User WHERE email = :email");
        $stmt->BindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Verify is Password is valid ?? Possible for login
    public function verifyPassword($email, $password)
    {
        $sql = "SELECT password FROM User WHERE email = :email";
        $stmt = $this->connection->prepare($sql);
        $stmt->BindParam(":email", $email);
        $stmt->execute();
        $passwordEnd = $stmt->fetch();
        if ($passwordEnd && $password === $passwordEnd["password"]) {
            echo "yes";
        } else {
            echo "no";
        }
    }

    // Registration - Checks if Email already exists if it exists i will throw an error
    public function CreatingAccount($email, $password)
    {
        $stmt = $this->connection->prepare("SELECT * FROM User WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "User already exists!";
        } else {

            $insertStmt = $this->connection->prepare("INSERT INTO User (email, password) VALUES (:email, :password)");
            $insertStmt->bindParam(":email", $email);
            $insertStmt->bindParam(":password", $password);
            $insertStmt->execute();

            echo "Account created successfully!";
        }
    }

    // UserEditing 
    public function UserEdit($User_id, $FirstName, $LastName, $Phone, $DriverLicence,$country,$city,$address,$zip)
    {
        $sql = "UPDATE User SET FirstName = :FirstName, LastName = :LastName, Phone = :Phone, DriverLicense=:DriverLicence, country=:country, city=:city, address=:address,zip=:zip WHERE user_id = :id";
        $stmt = $this->connection->prepare($sql);

        $stmt->bindParam(":FirstName", $FirstName);
        $stmt->bindParam(":LastName", $LastName);
        $stmt->bindParam(":Phone", $Phone);
        $stmt->bindParam(":DriverLicence", $DriverLicence);
        $stmt->bindParam(":id", $User_id);
        $stmt->bindParam(":country", $country);
        $stmt->bindParam(":city", $city);
        $stmt->bindParam(":address", $address);
        $stmt->bindParam(":zip", $zip);

        return $stmt->execute();
    }

    //Deleting Account
    public function DeleteUser($email)
    {
        $sql = "DELETE FROM User WHERE Email = :email";
        $stmt = $this->connection->prepare($sql);
        $stmt->BindParam(":email", $email);
        $stmt->execute();
    }
    public function DeleteById($id)
    {
        $sql = "DELETE FROM User WHERE user_id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->BindParam(":id", $id);
        $stmt->execute();
    }

    public function get_user_by_email_user($email)
    {
        $sql = "SELECT email,FirstName,LastName,Phone,DriverLicense,country,city,address,zip   FROM User WHERE email = :email";
        $stmt = $this->connection->prepare($sql);
        $stmt->BindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function get_user_by_id_user($user_id)
    {
        $sql = "SELECT email,FirstName,LastName,Phone,DriverLicense,country,city,address,zip  FROM User WHERE user_id = :user_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->BindParam(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllADMIN()
    {
        $sql = "SELECT * FROM User";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
