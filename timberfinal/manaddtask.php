<?php
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "timberstoredb"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "add") {
    $taskid = $_POST["taskid"];
    $empid = $_POST["empid"];
    $desc = $_POST["desc"];
    $deadline = $_POST["deadline"];
    $assigneddate = date("Y-m-d");
    $status = "Pending";

    // Prepare the SQL statement
    $sql = "INSERT INTO task (taskid, employeeid, taskdescription, assigneddate, deadline, status) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("ssssss", $taskid, $empid, $desc, $assigneddate, $deadline, $status);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('Task added successfully'); window.location.href='manaddtask.html';</script>";
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing SQL statement: " . $conn->error;
    }
}

$conn->close();
?>
