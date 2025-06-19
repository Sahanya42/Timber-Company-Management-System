<!DOCTYPE html>
<html>
<head>
    <title>VIEW SHIPMENT | NEW SEDAWATTE TIMBER STORE</title>
    <link rel="stylesheet" type="text/css" href="CSS/functionCSS/style.css">
    <link rel="icon" href="IMG/timberlogo.png" type="image/x-icon">
    <style>
        .container {
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

$sql = "SELECT * FROM suppliershipment";
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
        <a href="stockmanagermain.html">Home</a>
        <a href="stmanempstockmanager.html">Employee</a>
        <a href="stmanaddwoodcategories.html">Wood Categories</a>
        <a href="stmanmanageinventory.html">Inventory</a>
        <a href="stmanaddnewproduct.php">Manage Product</a>
        <a class="active" href="stmanviewshipment.php">View Shipment</a>
        <a href="stmanreportinventory.php">Create Inventory Report</a>
    </div>

    <div class="container">
    <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <tr>
                    <th>Shipment ID</th>
                    <th>Shipment Date</th>
                    <th>Delivery Status</th>
                    <th>Delivery Date</th>
                </tr>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['suppliershipmentid']; ?></td>
                        <td><?php echo $row['shipmentdate']; ?></td>
                        <td><?php echo $row['deliverystatus']; ?></td>
                        <td><?php echo $row['deliverydate']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p class="error-message">No shipment data found.</p>
        <?php endif; ?>

        <?php mysqli_close($conn); ?>
    </div>
</body>
</html>
