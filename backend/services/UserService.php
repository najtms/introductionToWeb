<?php
require_once __DIR__ . "/BaseService.php";
require_once __DIR__ . "/../dao/UserDAO.php";

class UserService extends BaseService
{
    protected $dao;

    public function __construct()
    {
        $this->dao = new UserDAO();
        parent::__construct($this->dao);
    }

    public function getByEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->dao->getByEmail($email);
        } else {
            throw new Exception("Invalid Email form");
        }
    }

    public function verifyPassword($email, $password)
    {
        $user = $this->getByEmail($email);
        if (!$user) {
            throw new Exception("User doesn't exist!");
        }
        return $this->dao->verifyPassword($email, $password);
    }

    public function CreatingAccount($email, $passowrd)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if (strlen($passowrd) > 6) {
                return $this->dao->CreatingAccount($email, $passowrd);
            } else {
                throw new Exception("Password is short");
            }
        } else {
            throw new Exception("Invalid Email");
        }
    }

    public function UserEdit($User_id, $FirstName, $LastName, $Phone, $DriverLicence)
    {
        if (strlen($FirstName) >= 3 && strlen($LastName) >= 3) {
            return $this->dao->UserEdit($User_id, $FirstName, $LastName, $Phone, $DriverLicence);
        } else {
            throw new Exception("Name is too short to exist");
        }
    }

    public function DeleteUser($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }
        return $this->dao->DeleteUser($email);
    }
}
