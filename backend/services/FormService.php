<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/FormDAO.php';

class FormService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new FormDAO());
    }

    // Create a new form entry
    public function createForm($data)
    {
        return $this->dao->add($data);
    }

    // Get all forms
    public function getAllForms()
    {
        return $this->dao->getAll();
    }

    // Change status of a form by form_id
    public function changeStatus($form_id, $status)
    {
        return $this->dao->update($form_id, ['Status' => $status]);
    }
}