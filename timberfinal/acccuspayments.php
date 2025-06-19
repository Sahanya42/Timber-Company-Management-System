<!DOCTYPE html>
<html>
<head>
    <title>CUSTOMER PAYMENTS | NEW SEDAWATTE TIMBER STORE</title>
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

$sql = "SELECT customerpaymentid, customerid, cosamount, cuspaymentdate FROM customerpayments";
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
        <a href="accountant.html">Home</a>
        <a href="accempaccountant.html">Employee</a>
        <a href="accfromsupplier.html">From Supplier</a>
        <a href="accreportfinance.php">Create Report</a>
        <a href="accsuppay.html">Make Supplier Payment</a>
        <a href="acccreatesalaries.html">Salaries</a>
        <a class="active" href="acccuspayments.php">Customer Payments</a>
    </div>

    <div class="container">
    <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <tr>
                    <th>Payment ID</th>
                    <th>Customer ID</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                </tr>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['customerpaymentid']; ?></td>
                        <td><?php echo $row['customerid']; ?></td>
                        <td><?php echo number_format($row['cosamount'], 2); ?></td>
                        <td><?php echo $row['cuspaymentdate']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p class="error-message">No customer payment data found.</p>
        <?php endif; ?>

        <?php mysqli_close($conn); ?>
    </div>
</body>
</html>
