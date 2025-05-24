<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timberstoredb";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $packinglistid = $_POST['packinglistid'];
    $createdate = $_POST['createdate'];
    $quantity = $_POST['quantity'];
    $totalamt = $_POST['totalamt'];

    $sql = "INSERT INTO packinglist (packinglistid, createdate, quantity, totalamt) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("isid", $packinglistid, $createdate, $quantity, $totalamt);
    }

    if ($stmt) {
        if ($stmt->execute()) {
            echo "<script>alert('Action completed successfully.'); window.location.href='delmancreatepackinglist.html';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing SQL statement: " . $conn->error;
    }
}

mysqli_close($conn);
?>
