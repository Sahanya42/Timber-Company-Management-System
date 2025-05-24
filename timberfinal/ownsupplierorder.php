<?php
$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "timberstoredb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == "placeorder") {

    $orderdate = $_POST['orderdate'];
    $suppliername = $_POST['suppliername'];
    $status = $_POST['status'];
    $totalamt = $_POST['totalamt'];

    $sql = "INSERT INTO supplierorder (supplierorderdate, suppliername, supplierorderstatus, totalamount) 
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssd", $orderdate, $suppliername, $status, $totalamt);

    if ($stmt->execute()) {
        echo "<script>alert('Department added successfully.'); window.location.href='ownplacesupplierorder.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
