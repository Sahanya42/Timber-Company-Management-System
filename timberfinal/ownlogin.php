<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timberstoredb";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit;
}

$input_username = $_POST['username'];
$input_password = $_POST['password'];

if (empty($input_username) || empty($input_password)) {
    echo "<script>alert('Both fields are required.'); window.location.href='ownerlogin.html';</script>";
    exit;
}

$sql = "SELECT * FROM owner WHERE ownerusername='$input_username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $owner = mysqli_fetch_assoc($result);

    if ($input_password == $owner['ownerpassword']) { 
        $_SESSION['ownerusername'] = $input_username; 
        echo "<script>alert('Login successful! Redirecting to owner home.'); window.location.href='ownermain.html';</script>";
        exit;
    } else {
        echo "<script>alert('Invalid password.'); window.location.href='ownerlogin.html';</script>";
    }
} else {
    echo "<script>alert('No owner found with this username.'); window.location.href='login.html';</script>";
}

mysqli_close($conn);
?>
