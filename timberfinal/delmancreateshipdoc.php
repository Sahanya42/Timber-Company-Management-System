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
    $shipdocid = $_POST['shipdocid'];
    $carriername = $_POST['carriername'];
    $dateissued = $_POST['dateissued'];
    $trackingnum = $_POST['trackingnum'];

    $sql = "INSERT INTO compshippingdocument (compshippingdocumentid, compcarrier, compdateissued, comptrackingnumber) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("issi", $shipdocid, $carriername, $dateissued, $trackingnum);
        }

    if ($stmt) {
        if ($stmt->execute()) {
            echo "<script>alert('Action completed successfully.'); window.location.href='delmancreateshipdoc.html';</script>";
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
