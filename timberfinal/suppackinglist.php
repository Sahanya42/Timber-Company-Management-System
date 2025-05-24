<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timberstoredb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplierpackinglistid = $_POST['packinglistid'];
    $supplierid = $_POST['supplierid'];
    $createdate = $_POST['createdate'];
    $quantity = $_POST['quantity'];
    $totalamt = $_POST['totalamt'];

    $sql = "INSERT INTO supplierpackinglist (supplierpackinglistid, supplierid  createdate, quantity, totalamt)
            VALUES ('$supplierpackinglistid', '$supplierid', '$createdate', '$quantity', '$totalamt')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Operation successful.');window.location.href='suppackinglist.html';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
