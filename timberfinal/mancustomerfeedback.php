<!DOCTYPE html>
<html>
<head>
    <title>MANAGER | NEW SEDAWATTE TIMBER STORE</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="timberlogo.png" type="image/x-icon">
    <style>
        table {
            width: 80%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 20px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #800000;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .error-message {
            color: red;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timberstoredb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM feedback";
$result = $conn->query($sql);
?>
    <div class="header">
        <div class="back-button">
            <a href="javascript:history.back()">&#10096; Back</a>
        </div>
        NEW SEDAWATTE TIMBER STORES
        <button class="logout-btn" onclick="window.location.href='1main.html'">LOGOUT</button>
    </div>
    
    <div class="tabs">
        <a href="managermain.html">Home</a>
        <a href="manempmanager.html">Employee</a>
        <a href="manaddtask.html">Add Task</a>
        <a href="manviewinventory.php">View Inventory</a>
        <a href="manreportsales.php">Sales Report</a>
        <a class="active" href="mancustomerfeedback.php">Customer Feedback</a>
    </div>

    <div class="container">
    <table>
            <thead>
                <tr>
                    <th>Feedback ID</th>
                    <th>Customer ID</th>
                    <th>Feedback Text</th>
                    <th>Submitted Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["feedbackid"] . "</td>
                                <td>" . $row["customerid"] . "</td>
                                <td>" . $row["feedbacktext"] . "</td>
                                <td>" . $row["submittedtime"] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='error-message'>No feedback found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    
    <?php
    $conn->close();
    ?>
</body>
</html>
