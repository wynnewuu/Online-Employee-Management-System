<?php
// Controller action for both Post action and getting list. Can be made into a class for more complex actions
require "model.php";
$data = [];
$db = new SimpleDB();

if (isset($_POST['submit'])) { // Check if post action
    $conditions = [
        ":bdate" => date("Y-m-d")
    ];
    $message = "Success";
    $errors = [];
    $attributes = [
        "essn",
        "dependent_name",
        "sex",
        "bdate",
        "relationship"
    ];

    // Create conditions for query and where statement
    foreach ($attributes as $attribute) {
        $value = $_POST[$attribute];
        if ($value) {
            $conditions[":$attribute"] = $value;
        } else {
            $errors[] = $attribute;
        }
    }

    if ($errors) {
        $message = "Could not add dependent - Empty attributes " . implode(", ", $errors);
    } else {
        // Insert Sql statment with interpolated variables `:variable`
        $sql = "INSERT INTO DEPENDENT (essn, dependent_name, sex, bdate, relationship) VALUES (:essn, :dependent_name, :sex, :bdate, :relationship)";
        // Insert data from post action
        $result = $db->insertDependent($sql, $conditions);

        if (is_string($result)) {
            $message = "Could not add dependent - " . $result;
        } else {
            $data['dependent'] = $result;
        }
    }

    // Return calls
    $data['message'] = $message;
} else {
    $conditions = [];
    $where = "";
    $attributes = [
        "essn",
        "dependent_name",
        "sex",
        "bdate",
        "relationship"
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
    $sql = "SELECT essn, dependent_name, sex, bdate, relationship
    FROM DEPENDENT";
    $sql .= $where ? " WHERE $where" : "";


    // Get data from post action
    $result = $db->query($sql, $conditions);
    $data = [
        'message' => $result ? '' : 'No Dependent Found',
        'dependent' => $result[0] ?? null
    ];
}

$relativePath = preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']);
header("Location:" . $relativePath . "index.php?" . http_build_query($data));
