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
    $supid = $_POST['supid'];
    $supname = $_POST['supname'];
    $supcont = $_POST['supcont'];
    $email = $_POST['email'];
    $supadd = $_POST['supadd'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($action == "add") {
        $sql = "INSERT INTO supplier (supplierid, suppliername, suppliercontact, supplieremail, supplieraddress, supplierusername, supplierpassword) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            // Bind parameters for add action
            $stmt->bind_param("issssss", $supid, $supname, $supcont, $email, $supadd, $username, $password);
        }
    }
    elseif ($action == "update") {
        $sql = "UPDATE supplier SET suppliername = ?, suppliercontact = ?, supplieremail = ?, supplieraddress = ?, 
                supplierusername = ?, supplierpassword = ? WHERE supplierid = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssssi", $supname, $supcont, $email, $supadd, $username, $password, $supid);
        }
    }
    elseif ($action == "delete") {
        $sql = "DELETE FROM supplier WHERE supplierid = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $supid);
        }
    }

    if ($stmt) {
        if ($stmt->execute()) {
            echo "<script>alert('Supplier added successfully.'); window.location.href='ownmanagesup.html';</script>";
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
