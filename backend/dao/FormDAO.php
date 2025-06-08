<?php
require_once __DIR__ . '/BaseDAO.php';

class FormDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct("Forms", "form_id");
    }
}