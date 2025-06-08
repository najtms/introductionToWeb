<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/UserDAO.php';

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

    public function get_user_by_email_user($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->dao->get_user_by_email_user($email);
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

    public function CreatingAccount($email, $password)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if (strlen($password) > 6) {
                return $this->dao->CreatingAccount($email, $password);
            } else {
                throw new Exception("Password is short");
            }
        } else {
            throw new Exception("Invalid Email");
        }
    }

    public function UserEdit($User_id, $FirstName, $LastName, $Phone, $DriverLicence,$country,$city,$address,$zip)
    {
        if (strlen($FirstName) >= 3 && strlen($LastName) >= 3) {
            return $this->dao->UserEdit($User_id, $FirstName, $LastName, $Phone, $DriverLicence, $country, $city, $address, $zip);
        } else {
            throw new Exception("Name is too short to exist");
        }
    }

    public function DeleteUser($email)
    {
        // Accept both email and numeric ID for deletion
        if (is_numeric($email)) {
            return $this->dao->delete($email);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }
        return $this->dao->DeleteUser($email);
    }

    public function get_user_by_id_user($id) {
        if (is_numeric($id)) {
            return $this->dao->get_user_by_id_user($id);
        } else {
            throw new Exception("Invalid ID");
        }
        
    }

    public function DeleteById($id)
    {
        if (is_numeric($id)) {
            return $this->dao->DeleteById($id);
        } else {
            throw new Exception("Invalid ID");
        }
    }

    public function getAllADMIN()
    {
        return $this->dao->getAllADMIN();
    }
}   