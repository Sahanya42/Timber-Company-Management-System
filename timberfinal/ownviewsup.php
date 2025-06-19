<!DOCTYPE html>
<html>
<head>
    <title>MANAGE SUPPLIER | NEW SEDAWATTE TIMBER STORE</title>
    <link rel="stylesheet" type="text/css" href="functionstyle.css">
    <link rel="icon" href="IMG/timberlogo.png" type="image/x-icon">
    <style>
        .container{
            width: 90%;
        }
        table {
            width: 80%;
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

$sql = "SELECT * FROM supplier";
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
        <a href="ownmanageemp.html">Employee</a>
        <a class="active" href="ownmanagesup.html">Supplier</a>
        <a href="ownmanagedep.html">Department</a>
        <a href="ownviewinventory.php">Inventory</a>
        <a href="ownreports.html">Reports</a>
        <a href="ownplacesupplierorder.html">Place Order</a>
    </div>

    <div class="container">
    <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <tr>
                    <th>Supplier ID</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Username</th>
                    <th>Password</th>
                </tr>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['supplierid']; ?></td>
                        <td><?php echo $row['suppliername']; ?></td>
                        <td><?php echo $row['suppliercontact']; ?></td>
                        <td><?php echo $row['supplieremail']; ?></td>
                        <td><?php echo $row['supplieraddress']; ?></td>
                        <td><?php echo $row['supplierusername']; ?></td>
                        <td><?php echo $row['supplierpassword']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p class="error-message">No supplier data found.</p>
        <?php endif; ?>

        <?php mysqli_close($conn); ?>
    </div>
</body>
</html>
