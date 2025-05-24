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
    echo "<script>alert('Both fields are required.'); window.location.href='login.html';</script>";
    exit;
}

$sql = "SELECT * FROM customer WHERE customerusername='$input_username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $customer = mysqli_fetch_assoc($result);

    if ($input_password == $customer['customerpassword']) { 
        $_SESSION['customerusername'] = $input_username; 
        echo "<script>alert('Login successful! Redirecting to customer home.'); window.location.href='customermain.html';</script>";
        exit;
    } else {
        echo "<script>alert('Invalid password.'); window.location.href='login.html';</script>";
    }
} else {
    echo "<script>alert('No customer found with this username.'); window.location.href='login.html';</script>";
}

mysqli_close($conn);
?>
