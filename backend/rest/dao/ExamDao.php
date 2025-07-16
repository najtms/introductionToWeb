<?php
require_once __DIR__ . "/../config.php";

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
        // "mysql:host=localhost;dbname=my_database;port=3306",
        //"my_username",
        //"my_password",
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
   * Implement DAO method used to get employees performance report
   */
  public function employees_performance_report()
  {
    $sql = ("SELECT e.employeeNumber, CONCAT(e.firstName,' ', e.lastName) as FullName, e.email, SUM(p.amount) as salary FROM employees e JOIN customers c ON e.employeeNumber = c.salesRepEmployeeNumber JOIN payments p ON c.customerNumber  = p.customerNumber GROUP BY e.employeeNumber");
    $stmt = $this->connection->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /** TODO
   * Implement DAO method used to delete employee by id
   */
  public function delete_employee($employee_id)
  {
    try {
      $stmt = $this->connection->prepare("DELETE FROM employees WHERE employeeNumber = :employeeNumber");
      $stmt->bindParam(':employeeNumber', $employee_id, PDO::PARAM_INT);
      $stmt->execute();
    } catch (Exception $e) {
      error_log("Delete employee error: " . $e->getMessage());
      return false;
    }
  }

  /** TODO
   * Implement DAO method used to edit employee data
   */
  public function edit_employee($employee_id, $data)
  {
    if (!$data || !is_array($data)) return false;
    $stmt = $this->connection->prepare("UPDATE employees SET lastName = :lastName, firstName = :firstName, extension = :extension, email = :email, officeCode = :officeCode, jobTitle = :jobTitle WHERE employeeNumber = :employeeNumber");
    $stmt->bindParam(':employeeNumber', $employee_id);
    $stmt->bindParam(':lastName', $data['lastName']);
    $stmt->bindParam(':firstName', $data['firstName']);
    $stmt->bindParam(':extension', $data['extension']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':officeCode', $data['officeCode']);
    $stmt->bindParam(':jobTitle', $data['jobTitle']);
    $stmt->execute();
  }
  public function get_orders_report()
  {
    $sql = "SELECT o.orderNumber, SUM(od.quantityOrdered * od.priceEach) AS total_amount FROM orders o JOIN orderdetails od ON o.orderNumber = od.orderNumber GROUP BY o.orderNumber";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /** TODO
   * Implement DAO method used to get all products in a single order
   */
  public function get_order_details($order_id)
  {
    $sql = "SELECT p.productName,o.quantityOrdered,o.priceEach  FROM orderdetails o JOIN products p ON o.productCode = p.productCode WHERE o.orderNumber = :orderNumber";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':orderNumber', $order_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Get a single employee by id
   */
  public function get_employee($employee_id)
  {
    $stmt = $this->connection->prepare("SELECT * FROM employees WHERE employeeNumber = :employeeNumber");
    $stmt->bindParam(':employeeNumber', $employee_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
