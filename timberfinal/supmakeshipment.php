<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timberstoredb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
    $suppliershipmentid = $_POST['shipmentid'];
    $supplierid = $_POST['supplierid'];
    $shipmentdate = $_POST['shipmentdate'];
    $deliverystatus = $_POST['deliverystatus'];
    $deliverydate = $_POST['deliverydate'];

    $sql = "INSERT INTO suppliershipment (suppliershipmentid, supplierid, shipmentdate, deliverystatus, deliverydate)
            VALUES ('$suppliershipmentid', '$supplierid', '$shipmentdate', '$deliverystatus', '$deliverydate')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Operation successful.');window.location.href='supmakeshipment.html';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
