<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timberstoredb"; 

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$customerid = $_POST['customerid'];
$feedbacktext = $_POST['feedback'];

$sql = "INSERT INTO feedback (customerid, feedbacktext) VALUES ('$customerid', '$feedbacktext')";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Feedback submitted successfully!'); window.location.href='cusprovidefeedback.html';</script>";
} else {
    echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href='cusprovidefeedback.html';</script>";
}

mysqli_close($conn);
?>
