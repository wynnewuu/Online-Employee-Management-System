<?php
// Controller action for both Post action and getting list. Can be made into a class for more complex actions
require "model.php";
$data = [];
$db = new SimpleDB();

if (isset($_GET['submit'])) { // Check if post action

    $conditions = [];
    $where = "";
    $attributes = [
      	"dnumber",
      	"dlocation"
    ];

    // Create conditions for query and where statement
    $index = 0;
    foreach ($attributes as $attribute) {
        $value = $_GET[$attribute];

        if ($value != NULL) {
            $conditions[':' . $attribute] = $value;
            $where .= $index > 0 ? " AND " : "";
            $where .= $attribute . "= :$attribute";
            $index++;
        }
    }

    // Insert Sql statment with interpolated variables `:variable`
    $sql = "SELECT dnumber, dlocation 
    FROM DEPT_LOCATIONS";
    $sql .= $where ? " WHERE $where" : "";


    // Get data from post action
    $result = $db->query($sql, $conditions);
    $data = [
        'message' => $result ? '' : 'No Dependent Location Found',
        'locations' => $result[0] ?? null
    ];
}

$relativePath = preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']);
header("Location:" . $relativePath . "index.php?" . http_build_query($data));
