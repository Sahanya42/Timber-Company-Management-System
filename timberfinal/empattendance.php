<!DOCTYPE html>
<html>
<head>
    <title>ATTENDANCE | NEW SEDAWATTE TIMBER STORES</title>
    <link rel="stylesheet" type="text/css" href="CSS/style.css">
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
        <a href="emptask.php">Task</a>
        <a class="active" href="empattendance.php">Attendance</a>
        <a href="empsalary.php">Salary</a>
    </div>

    <div class="container">
        <form action = "" method = "POST">
            <div class="form-group">
                <lable for="employeeid">Employee ID</lable>
                <input type="text" name="employeeid" required>
            </div>

            <div class="form-group">
                <lable for="checkintime">Check-In Time</lable>
                <input type="time" name="checkintime" required>
            </div>

            <div class="form-group">
            <lable for="checkouttime">Check-Out Time</lable>
            <input type="time" name="checkouttime" required>
            </div>

            <div class="buttons">
            <button type="submit" name="add">Add Attendance</button>
            <button type="submit" name="update">Update Attendance</button>
            <button type="submit" name="view">View Attendance</button>
            </div>
        </form>

        <div class="attendance-section">
            <table>
                <thead>
                    <tr>
                        <th>Record ID</th>
                        <th>Employee ID</th>
                        <th>Check-In Time</th>
                        <th>Check-Out Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "timberstoredb";

                    $conn = mysqli_connect($servername, $username, $password, $dbname);

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    if (isset($_POST['add'])) {
                        $employeeid = $_POST['employeeid'];
                        $checkintime = $_POST['checkintime'];
                        $checkouttime = $_POST['checkouttime'];

                        $sql = "INSERT INTO attendance (employeeid, checkintime, checkouttime) VALUES (?, ?, ?)";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "iss", $employeeid, $checkintime, $checkouttime);

                        if (mysqli_stmt_execute($stmt)) {
                            echo "<p class='success-message'>Attendance added successfully.</p>";
                        } else {
                            echo "<p class='error-message'>Error: " . mysqli_error($conn) . "</p>";
                        }

                        mysqli_stmt_close($stmt);
                    }

                    if (isset($_POST['update'])) {
                        $employeeid = $_POST['employeeid'];
                        $checkintime = $_POST['checkintime'];
                        $checkouttime = $_POST['checkouttime'];

                        $sql = "UPDATE attendance SET checkintime = ?, checkouttime = ? WHERE employeeid = ?";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "ssi", $checkintime, $checkouttime, $employeeid);

                        if (mysqli_stmt_execute($stmt)) {
                            echo "<p class='success-message'>Attendance updated successfully.</p>";
                        } else {
                            echo "<p class='error-message'>Error: " . mysqli_error($conn) . "</p>";
                        }

                        mysqli_stmt_close($stmt);
                    }

                    if (isset($_POST['view'])) {
                        echo "<p class='success-message'>Attendance records retrieved successfully.</p>";
                    }

                    $sql = "SELECT * FROM attendance";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['attendancerecordid'] . "</td>";
                            echo "<td>" . $row['employeeid'] . "</td>";
                            echo "<td>" . $row['checkintime'] . "</td>";
                            echo "<td>" . $row['checkouttime'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No attendance records found</td></tr>";
                    }

                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
