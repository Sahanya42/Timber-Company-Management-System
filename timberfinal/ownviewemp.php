<!DOCTYPE html>
<html>
<head>
    <title>MANAGE EMPLOYEE | NEW SEDAWATTE TIMBER STORE</title>
    <link rel="stylesheet" type="text/css" href="functionstyle.css">
    <link rel="icon" href="IMG/timberlogo.png" type="image/x-icon">
    <style>
        .container{
            width: 95%;
        }
        table {
            width: 40%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 6px 5px;
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
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timberstoredb";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM employee";
$result = mysqli_query($conn, $sql);
?>
    <div class="header">
        <div class="back-button">
            <a href="javascript:history.back()">&#10096; Back</a>
        </div>
        NEW SEDAWATTE TIMBER STORES
        <button class="logout-btn" onclick="window.location.href='1main.html'">LOGOUT</button>
    </div>

    <div class="tabs">
        <a class="active" href="ownmanageemp.html">Employee</a>
        <a href="ownmanagesup.html">Supplier</a>
        <a href="ownmanagedep.html">Department</a>
        <a href="ownviewinventory.php">Inventory</a>
        <a href="ownreports.html">Reports</a>
        <a href="ownplacesupplierorder.html">Place Order</a>
    </div>

    <div class="container">
    <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <tr>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Delivery Route</th>
                    <th>Daily Deliveries</th>
                    <th>Years of Experience</th>
                    <th>Report Frequency</th>
                    <th>Section</th>
                    <th>Storage Filled</th>
                    <th>Team Size</th>
                    <th>Manager Shift</th>
                    <th>Cashier Shift</th>
                </tr>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['employeeid']; ?></td>
                        <td><?php echo $row['employeename']; ?></td>
                        <td><?php echo $row['employeecontact']; ?></td>
                        <td><?php echo $row['employeeemail']; ?></td>
                        <td><?php echo $row['employeetype']; ?></td>
                        <td><?php echo $row['employeeusername']; ?></td>
                        <td><?php echo $row['employeepassword']; ?></td>
                        <td><?php echo $row['deliveryroute']; ?></td>
                        <td><?php echo $row['dailydeliveries']; ?></td>
                        <td><?php echo $row['yearsodexperience']; ?></td>
                        <td><?php echo $row['reportfrequency']; ?></td>
                        <td><?php echo $row['section']; ?></td>
                        <td><?php echo $row['storagefilled']; ?></td>
                        <td><?php echo $row['teamsize']; ?></td>
                        <td><?php echo $row['managershift']; ?></td>
                        <td><?php echo $row['cashiershift']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p class="error-message">No employee data found.</p>
        <?php endif; ?>

        <?php mysqli_close($conn); ?>
    </div>
</body>
</html>
