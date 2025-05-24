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
    $action = $_POST['action'];
    $depid = $_POST['depid'];
    $depname = $_POST['depname'];
    $dephead = $_POST['dephead'];
    $email = $_POST['email'];

    if ($action == "add") {
        $sql = "INSERT INTO department (departmentid, departmentname, departmenthead, departmentheademail) 
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("isss", $depid, $depname, $dephead, $email);
        }
    }
    elseif ($action == "update") {
        $sql = "UPDATE department SET departmentname = ?, departmenthead = ?, departmentheademail = ? WHERE departmentid = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sssi", $depname, $dephead, $email, $depid);
        }
    }
    elseif ($action == "delete") {
        $sql = "DELETE FROM department WHERE departmentid = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $depid);
        }
    }

    if ($stmt) {
        if ($stmt->execute()) {
            echo "<script>alert('Department added successfully.'); window.location.href='ownmanagedep.html';</script>";
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
