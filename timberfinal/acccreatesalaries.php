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
    $salarytypeid = $_POST['salarytypeid'];
    $salarytype = $_POST['salarytype'];
    $salary = $_POST['salaryamount'];

    if ($action == "add") {
        $sql = "INSERT INTO salarytype (salarytypeid, salarytype, salary) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("isd", $salarytypeid, $salarytype, $salary);
        }
    }
    elseif ($action == "update") {
        $sql = "UPDATE salarytype SET salarytype = ?, salary = ? WHERE salarytypeid = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sdi", $salarytype, $salary, $salarytypeid);
        }
    }
    elseif ($action == "delete") {
        $sql = "DELETE FROM salarytype WHERE salarytypeid = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $salarytypeid);
        }
    }

    if ($stmt) {
        if ($stmt->execute()) {
            echo "<script>alert('Action completed successfully.'); window.location.href='acccreatesalaries.html';</script>";
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
