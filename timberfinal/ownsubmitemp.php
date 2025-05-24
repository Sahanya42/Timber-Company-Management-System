<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timberstoredb";

// Enable error reporting for more detailed errors
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $empid = $_POST['empid'];
    $empname = $_POST['empname'];
    $empcont = $_POST['empcont'];
    $email = $_POST['email'];
    $employeeType = $_POST['employeeType'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Optional fields
    $deliveryRoutes = $_POST['deliveryroutes'] ?? null;
    $dailyDeliveries = $_POST['dailydeliveries'] ?? null;
    $yearsOfExperience = $_POST['yearsofexperience'] ?? null;
    $reportFrequency = $_POST['reportfrequency'] ?? null;
    $section = $_POST['section'] ?? null;
    $storageFilled = $_POST['storagefilled'] ?? null;
    $teamSize = $_POST['teamsize'] ?? null;
    $managershift = $_POST['managershift'] ?? null;
    $cashiershift = $_POST['cashiershift'] ?? null;

    // Handle "add" action
    if ($action == "add") {
        $sql = "INSERT INTO employee (employeeid, employeename, employeecontact, employeeemail, employeetype, employeeusername, employeepassword, 
                                      deliveryroute, dailydeliveries, yearsodexperience, reportfrequency, section, storagefilled, teamsize, managershift, cashiershift) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            // Bind parameters
            $stmt->bind_param("issssssssssssiii", $empid, $empname, $empcont, $email, $employeeType, $username, $password, 
                              $deliveryRoutes, $dailyDeliveries, $yearsOfExperience, $reportFrequency, $section, 
                              $storageFilled, $teamSize, $managershift, $cashiershift);
        }
    }
    // Handle "update" action
    elseif ($action == "update") {
        $sql = "UPDATE employee SET employeename = ?, employeecontact = ?, employeeemail = ?, 
                employeetype = ?, employeeusername = ?, employeepassword = ?, 
                deliveryroute = ?, dailydeliveries = ?, yearsodexperience = ?, 
                reportfrequency = ?, section = ?, storagefilled = ?, teamsize = ?, managershift = ?, cashiershift = ? 
                WHERE employeeid = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            // Bind parameters for update
            $stmt->bind_param("ssssssssssssiiii", $empname, $empcont, $email, $employeeType, $username, $password, 
                              $deliveryRoutes, $dailyDeliveries, $yearsOfExperience, $reportFrequency, 
                              $section, $storageFilled, $teamSize, $managershift, $cashiershift, $empid);
        }
    }
    // Handle "delete" action
    elseif ($action == "delete") {
        $sql = "DELETE FROM employee WHERE employeeid = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            // Bind parameter for delete
            $stmt->bind_param("i", $empid);
        }
    }

    // Check if the statement was prepared correctly
    if ($stmt) {
        // Execute query
        if ($stmt->execute()) {
            echo "<script>alert('Operation successful.');window.location.href='ownmanageemp.html';</script>";
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
