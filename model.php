<?php

/**
 * Database model for employee. 
 * Inserting and Selecting based on controller statement
 */

require "envLoader.php";

class SimpleDB {
  private $pdo = null;
  private $stmt = null;

  // Establish connection to Database
  function __construct() {
    (new DotEnv(__DIR__ . '/.env'))->load();
    try {
      // Using PDO over Mysqli since PDO works with more than just mysql databases
      // These same aspects can we rearranged for mysqli instances
      $this->pdo = new PDO(
        "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASSWORD'],
        [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Error mode to use
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Use associative array instead of object
        ]
      );
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  // Close connection with database
  function __destruct() {
    //Remove existing statements
    if ($this->stmt !== null) {
      $this->stmt = null;
    }
    //Remove pdo instance (close db connection)
    if ($this->pdo !== null) {
      $this->pdo = null;
    }
  }

  /**
   * Select Action
   * @return Array of objects or error statement
   */
  function query($sql, $cond = null) {
    try {
      $this->stmt = $this->pdo->prepare($sql); // Prepare sql statement
      $this->stmt->execute($cond); // Execute sql statement with interpolated data
      return $this->stmt->fetchAll(); // Get selected items
    } catch (Exception $ex) {
      return $ex->getMessage();
    }
  }

  /**
   * Insert Action
   * @return Integer of last added id or error message
   */
  function insert($sql, $cond = null) {
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($cond);
      $selectCond = [':ssn' => $cond[':ssn']];
      return $this->query("SELECT ssn, bdate, fname, lname, address, salary, dno 
      FROM EMPLOYEE WHERE ssn = :ssn", $selectCond);
    } catch (Exception $ex) {
      return $ex->getMessage();
    }
  }
  
  function insertDependent($sql, $cond = null) {
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($cond);
      $selectCond = [':essn' => $cond[':essn']];
      return $this->query("SELECT essn, dependent_name, sex, bdate, relationship
      FROM DEPENDENT WHERE essn = :essn", $selectCond);
    } catch (Exception $ex) {
      return $ex->getMessage();
    }
  }
  
  function insertDepartment($sql, $cond = null) {
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($cond);
      $selectCond = [':dnumber' => $cond[':dnumber']];
      return $this->query("SELECT dnumber, dname, mgr_ssn, mgr_start_date
      FROM DEPARTMENT WHERE dnumber = :dnumber", $selectCond);
    } catch (Exception $ex) {
      return $ex->getMessage();
    }
  }
  
}
