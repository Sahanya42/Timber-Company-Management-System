<!DOCTYPE html>
<html>
<head>
    <title>PURCHASE HISTORY | NEW SEDAWATTE TIMBER STORE</title>
    <link rel="stylesheet" type="text/css" href="cusstyle.css">
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
    <div class="header">
        <div class="back-button">
            <a href="javascript:history.back()">&#10096; Back</a>
        </div>
        
        NEW SEDAWATTE TIMBER STORES
        <button class="logout-btn" onclick="window.location.href='1main.html'">LOGOUT</button>
    </div>

    <div class="tabs">
        <a href="catalog.html">Catalog</a>
        <a href="cusplaceneworder.php">Place Order</a>
        <a href="cusprovidefeedback.html">Give Feedback</a>
        <a class="active" href="cuspurchasehistory.php">Purchase History</a>
        <a href="cusinvoice.php">Invoice</a>
        <a href="cusmakepayment.html">Make Payment</a>
    </div>

    <div class="container">
        <form method="GET" action="#">
            <div class="form-group">
                <label for="customerid">Customer ID</label>
                <input type="text" name="customerid" placeholder="Enter Customer ID" required>
            </div>
            <div class="buttons">
                <button type="submit">View Purchase History</button>
            </div>
        </form>
    </div>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "timberstoredb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['customerid'])) {
        $customerid = $_GET['customerid'];

        $sql = "SELECT orderid, productid, quantity, price FROM orders WHERE customerid = '$customerid'";
        $result = mysqli_query($conn, $sql);
    ?>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product ID</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $totalPrice = $row['quantity'] * $row['price'];
                ?>
                    <tr>
                        <td><?php echo $row['orderid']; ?></td>
                        <td><?php echo $row['productid']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo number_format($row['price'], 2); ?></td>
                        <td><?php echo number_format($totalPrice, 2); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php
    }
    $conn->close();
    ?>
</body>
</html>
