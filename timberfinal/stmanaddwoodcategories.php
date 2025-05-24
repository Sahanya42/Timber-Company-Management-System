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
    $categoryid = $_POST['categoryid'];
    $categoryname = $_POST['categoryname'];

    if (empty($categoryid) || empty($categoryname)) {
        echo "<script>alert('Both fields are required.'); window.location.href='stmanaddwoodcategories.html';</script>";
        exit;
    }

    $sql = "INSERT INTO woodtypecategories (categoryid, categoryname) VALUES ('$categoryid', '$categoryname')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Category added successfully.'); window.location.href='stmanaddwoodcategories.html';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href='stmanaddwoodcategories.html';</script>";
    }
}

mysqli_close($conn);
?>
