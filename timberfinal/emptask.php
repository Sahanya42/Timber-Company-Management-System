<!DOCTYPE html>
<html>
<head>
    <title>TASK | NEW SEDAWATTE TIMBER STORES</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="IMG/timberlogo.png" type="image/x-icon">
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
    <div class="header">
        <div class="back-button">
            <a href="javascript:history.back()">&#10096; Back</a>
        </div>
        
        NEW SEDAWATTE TIMBER STORES
        <button class="logout-btn" onclick="window.location.href='1main.html'">LOGOUT</button>
    </div>

    <div class="tabs">
        <a class="active" href="emptask.php">Task</a>
        <a href="empattendance.php">Attendance</a>
        <a href="empsalary.php">Salary</a>
    </div>

    <div class="container">
        <form method="GET" action="#">
            <div class="form-group">
                <label for="employee">Employee ID</label>
                <input type="text" name="employeeid" placeholder="Enter Employee ID" required>
            </div>
            <div class="buttons">
                <button type="submit">View Your Tasks</button>
            </div>
        </form>
        
        <div class="task-section">
            <table>
                <thead>
                    <tr>
                        <th>Task ID</th>
                        <th>Task Description</th>
                        <th>Assigned Date</th>
                        <th>Deadline</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    session_start();
                    
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "timberstoredb";

                    $conn = mysqli_connect($servername, $username, $password, $dbname);

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $employeeid = $_SESSION['employeeid'] ?? $_GET['employeeid'] ?? null;

                    if ($employeeid) {
                        $sql = "SELECT taskid, taskdescription, assigneddate, deadline, status FROM task WHERE employeeid = ?";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $employeeid);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['taskid'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['taskdescription']) . "</td>";
                                echo "<td>" . $row['assigneddate'] . "</td>";
                                echo "<td>" . $row['deadline'] . "</td>";
                                echo "<td>" . $row['status'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No tasks found for this employee</td></tr>";
                        }

                        mysqli_stmt_close($stmt);
                    } else {
                        echo "<tr><td colspan='5'>Employee ID not provided</td></tr>";
                    }

                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
