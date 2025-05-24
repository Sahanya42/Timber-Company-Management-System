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
    echo "<script>alert('Both fields are required.'); window.location.href='emplogin.html';</script>";
    exit;
}

$sql = "SELECT * FROM employee WHERE employeeusername='$input_username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $employee = mysqli_fetch_assoc($result);

    if ($employee['employeetype'] !== 'employee') {
        echo "<script>alert('You are not an employee.'); window.location.href='emplogin.html';</script>";
        exit;
    }

    if ($input_password == $employee['employeepassword']) { 
        $_SESSION['employeeusername'] = $input_username; 
        echo "<script>alert('Login successful! Redirecting to employee home.'); window.location.href='employeemain.html';</script>";
        exit;
    } else {
        echo "<script>alert('Invalid password.'); window.location.href='emplogin.html';</script>";
    }
} else {
    echo "<script>alert('No employee found with this username.'); window.location.href='emplogin.html';</script>";
}

mysqli_close($conn);
?>
