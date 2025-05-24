<!DOCTYPE html>
<html>
<head>
    <title>SALARY| NEW SEDAWATTE TIMBER STORE</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="timberlogo.png" type="image/x-icon">

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
        <a href="managermain.html">Home</a>
        <a href="manager.html">Manager</a>
        <a href="mantask.php">Task</a>
        <a href="manattendance.php">Attendance</a>
        <a class="active" href="mansalary.php">Salary</a>
    </div>

    <div class="container">
        <form action="mansalaryfind.php" method="POST">
            <div class="form-group">
                <label for="employeeid">Employee ID</label>
                <input type="text" name="employeeid">
            </div>

            <div class="form-group">
                <label for="department">Department</label>
                <input type="text" name="department">
            </div>

            <div class="form-group">
                <label for="basic">Basic</label>
                <input type="text" name="basic" readonly>
            </div>

            <div class="form-group">
                <label for="overtime">Over Time</label>
                <input type="text" name="overtime">
            </div>

            <div class="form-group">
                <label for="overtimesalary">Over Time Salary</label>
                <input type="text" name="overtimesalary" readonly>
            </div>

            <div class="form-group">
                <label for="bonus">Bonus</label>
                <input type="text" name="bonus" readonly>
            </div>

            <div class="form-group">
                <label for="totsal">Total Salary</label>
                <input type="text" name="totsal">
            </div>
            <div class="buttons">
                <button type="button" class="calculate-btn" onclick="calculateSalary()">Calculate Salary</button>
            </div>
        </form>
    </div>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "timberstoredb";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $basic = 0;
    $overtime_rate = 0;
    $bonus = 0;

    $salary_query = "
        SELECT salarytype, salary
        FROM salarytype
        WHERE salarytype IN ('Manager Basic', 'Manager Overtime', 'Manager Bonus')
    ";

    $result = mysqli_query($conn, $salary_query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['salarytype'] == 'Manager Basic') {
                $basic = $row['salary'];
            } elseif ($row['salarytype'] == 'Manager Overtime') {
                $overtime_rate = $row['salary'];
            } elseif ($row['salarytype'] == 'Manager Bonus') {
                $bonus = $row['salary'];
            }
        }
    }

    mysqli_close($conn);
    ?>

    <script>
        var basicSalary = <?php echo $basic; ?>;
        var overtimeRate = <?php echo $overtime_rate; ?>;
        var bonus = <?php echo $bonus; ?>;
    
        function calculateSalary() {
            var overtimeHours = parseFloat(document.querySelector('input[name="overtime"]').value) || 0;
    
            var overtimeSalary = overtimeHours * overtimeRate;
    
            var totalSalary = basicSalary + overtimeSalary + bonus;
    
            document.querySelector('input[name="basic"]').value = basicSalary;
            document.querySelector('input[name="overtimesalary"]').value = overtimeSalary;
            document.querySelector('input[name="bonus"]').value = bonus;
            document.querySelector('input[name="totsal"]').value = totalSalary;
        }
    </script>
</body>
</html>
