<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timberstoredb";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);

if (!$input) {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
    exit;
}

$customername = mysqli_real_escape_string($conn, $input['customername']);
$customeraddress = mysqli_real_escape_string($conn, $input['customeraddress']);
$customercontact = mysqli_real_escape_string($conn, $input['customercontact']);
$customeremail = mysqli_real_escape_string($conn, $input['customeremail']);
$customerusername = mysqli_real_escape_string($conn, $input['customerusername']);
$customerpassword = mysqli_real_escape_string($conn, $input['customerpassword']);

if (empty($customername) || empty($customeraddress) || empty($customercontact) || empty($customeremail) || empty($customerusername) || empty($customerpassword)) {
    echo json_encode(["success" => false, "message" => "All fields are required"]);
    exit;
}

$sql_check = "SELECT * FROM customer WHERE customerusername='$customerusername' OR customeremail='$customeremail'";
$result = mysqli_query($conn, $sql_check);

if (mysqli_num_rows($result) > 0) {
    echo json_encode(["success" => false, "message" => "Username or email already exists"]);
    exit;
}

$sql = "INSERT INTO customer (customername, customeraddress, customercontact, customeremail, customerusername, customerpassword) 
        VALUES ('$customername', '$customeraddress', '$customercontact', '$customeremail', '$customerusername', '$customerpassword')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["success" => true, "message" => "Signup successful"]);
} else {
    echo json_encode(["success" => false, "message" => "Error inserting record: " . mysqli_error($conn)]);
}

mysqli_close($conn);
?>
