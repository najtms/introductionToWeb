<?php
require_once __DIR__ . '/../dao/BaseDAO.php';

class BaseService
{
    protected $dao;

    public function __construct(BaseDao $dao)
    {
        $this->dao = $dao;
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }

    public function getById($id)
    {
        return $this->dao->getByID($id);
    }

    public function create($data)
    {
        $id = $this->dao->add($data);
        return $this->dao->getByID($id);
    }

    public function update($id, $data)
    {
        $this->dao->update($id, $data);
        return $this->dao->getByID($id);
    }

    public function delete($id)
    {
        return $this->dao->delete($id);
    }
    public function add($entity)
    {
        return $this->dao->add($entity);
    }
}
