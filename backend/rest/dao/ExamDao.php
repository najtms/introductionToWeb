<?php
require_once(__DIR__ . '/../../config.php');
class ExamDao
{

  private $connection;

  /**
   * constructor of dao class
   */
  public function __construct()
  {
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
      echo "Connection failed: " . $e->getMessage();
    }
  }

  /** TODO
   * Implement DAO method used to get customer information
   */
  public function get_customers()
  {
    $sql = "SELECT * FROM Customers";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  /** TODO
   * Implement DAO method used to get customer meals
   */
  public function get_customer_meals($customer_id)
  {
    $sql = "SELECT f.name,f.brand,m.created_at FROM Meals m 
    JOIN Foods f ON m.food_id = f.id
    WHERE customer_id = :customer_id";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':customer_id', $customer_id);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  /** TODO
   * Implement DAO method used to save customer data
   */
  public function add_customer($data)
  {
    $sql = "INSERT INTO customers (first_name, last_name, birth_date, status) VALUES (:first_name, :last_name, :birth_date, :status)";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':first_name', $data['first_name']);
    $stmt->bindParam(':last_name', $data['last_name']);
    $stmt->bindParam(':birth_date', $data['birth_date']);
    $stmt->bindParam(':status', $data['status']);
    $stmt->execute();
    return ['success' => true, 'id' => $this->connection->lastInsertId()];
  }

  /** TODO
   * Implement DAO method used to get foods report
   */
  public function get_foods_report($limit, $offset)
  {
    $stmt = $this->conn->prepare("SELECT f.id,f.name,f.brand,f.image_url,
    MAX(CASE WHEN n.name = 'energy' THEN fn.quantity ELSE 0 END) AS energy,
    MAX(CASE WHEN n.name = 'protein' THEN fn.quantity ELSE 0 END) AS protein,
    MAX(CASE WHEN n.name = 'fat' THEN fn.quantity ELSE 0 END) AS fat,
    MAX(CASE WHEN n.name = 'fiber' THEN fn.quantity ELSE 0 END) AS fiber,
    MAX(CASE WHEN n.name = 'Carb' THEN fn.quantity ELSE 0 END) AS carbs
    FROM foods f 
    JOIN food_nutrients fn ON f.id = fn.food_id
    JOIN nutrients n ON fn.nutrient_id = n.id
    GROUP by f.id
    LIMIT :limit OFFSET :offset");
    $stmt->BindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->BindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
