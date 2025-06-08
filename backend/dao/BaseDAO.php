<?php
require_once __DIR__ . '/../config.php';

class BaseDAO
{
    protected $table_name;
    protected $primary_key;
    protected $connection;

    public function __construct($table_name, $primary_key)
    {
        $this->table_name = $table_name;
        $this->primary_key = $primary_key;
        try {
            $this->connection = new PDO(
                "mysql:host=" . Config::DB_HOST() . ";dbname=" . Config::DB_NAME() . ";port=" . Config::DB_PORT(),
                Config::DB_USER(),
                Config::DB_PASSWORD(),
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function add($entity)
    {
        // Use prepared statements and filter input
        $filtered = $this->sanitizeArray($entity);
        $query = "INSERT INTO " . $this->table_name . " (";
        foreach ($filtered as $column => $value) {
            $query .= $column . ', ';
        }
        $query = substr($query, 0, -2);
        $query .= ") VALUES (";
        foreach ($filtered as $column => $value) {
            $query .= ":" . $column . ', ';
        }
        $query = substr($query, 0, -2);
        $query .= ")";

        $stmt = $this->connection->prepare($query);
        $stmt->execute($filtered);
        $filtered['id'] = $this->connection->lastInsertId();
        return $filtered;
    }

    public function getAll()
    {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table_name);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByID($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table_name . " WHERE " . $this->primary_key . " = :id");
        $stmt->bindValue(':id', is_array($id) ? $id[$this->primary_key] : $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function insert($data)
    {
        $filtered = $this->sanitizeArray($data);
        $columns = implode(", ", array_keys($filtered));
        $placeholders = ":" . implode(", :", array_keys($filtered));
        $sql = "INSERT INTO " . $this->table_name . " ($columns) VALUES ($placeholders)";

        $stmt = $this->connection->prepare($sql);

        foreach ($filtered as $key => &$value) {
            $stmt->bindParam(":$key", $value);
        }

        return $stmt->execute();
    }

    public function update($id, $data)
    {
        $filtered = $this->sanitizeArray($data);
        $fields = "";
        foreach ($filtered as $key => $value) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ", ");
        $sql = "UPDATE " . $this->table_name . " SET $fields WHERE " . $this->primary_key . " = :id";

        $stmt = $this->connection->prepare($sql);
        $filtered['id'] = $id;
        return $stmt->execute($filtered);
    }

    public function delete($id)
    {
        $stmt = $this->connection->prepare("DELETE FROM " . $this->table_name . " WHERE " . $this->primary_key . " = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function execute($query, $params = [])
    {
        $stmt = $this->connection->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt;
    }

    protected function query($query, $params)
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function query_unique($query, $params)
    {
        $results = $this->query($query, $params);
        return reset($results);
    }

    protected function sanitizeArray($arr)
    {
        $clean = [];
        foreach ($arr as $k => $v) {
            if (is_string($v)) {
                $v = strip_tags($v);
                $v = htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
            }
            $clean[$k] = $v;
        }
        return $clean;
    }
}
