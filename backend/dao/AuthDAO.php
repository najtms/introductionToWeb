<?php
require_once __DIR__ . '/BaseDAO.php';

class AuthDao extends BaseDao
{
    protected $table_name;


    public function __construct()
    {
        parent::__construct("User", "user_id");
    }
    public function get_user_by_email($email)
    {
        $query = "SELECT email, password, role, user_id FROM " . $this->table_name . " WHERE email = :email";
        return $this->query_unique($query, ['email' => $email]);
    }
}
