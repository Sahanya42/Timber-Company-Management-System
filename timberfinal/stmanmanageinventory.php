<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timberstoredb";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inventoryid = $_POST['inventoryid'];
    $locationcapacity = $_POST['locationcapacity'];
    $productquantity = $_POST['productquantity'];

    if (empty($inventoryid) || empty($locationcapacity) || empty($productquantity)) {
        echo "<script>alert('All fields are required.'); window.location.href='stmanmanageinventory.html';</script>";
        exit;
    }

    $sql = "INSERT INTO inventory (inventoryid, locationcapacity, productquantity) 
            VALUES ('$inventoryid', '$locationcapacity', '$productquantity')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Inventory added successfully.'); window.location.href='stmanmanageinventory.html';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href='stmanmanageinventory.html';</script>";
    }
}

mysqli_close($conn);
?>
