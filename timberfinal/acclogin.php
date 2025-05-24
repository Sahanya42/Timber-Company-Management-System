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
    echo "<script>alert('Both fields are required.'); window.location.href='acclogin.html';</script>";
    exit;
}

$sql = "SELECT * FROM employee WHERE employeeusername='$input_username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $employee = mysqli_fetch_assoc($result);

    if ($employee['employeetype'] !== 'Accountant') {
        echo "<script>alert('You are not an accountant.'); window.location.href='acclogin.html';</script>";
        exit;
    }

    if ($input_password == $employee['employeepassword']) { 
        $_SESSION['employeeusername'] = $input_username; 
        echo "<script>alert('Login successful! Redirecting to accountant home.'); window.location.href='accountantmain.html';</script>";
        exit;
    } else {
        echo "<script>alert('Invalid password.'); window.location.href='acclogin.html';</script>";
    }
} else {
    echo "<script>alert('No accountant found with this username.'); window.location.href='acclogin.html';</script>";
}

mysqli_close($conn);
?>
