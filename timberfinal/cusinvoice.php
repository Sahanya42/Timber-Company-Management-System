<!DOCTYPE html>
<html>
<head>
    <title>INVOICE | NEW SEDAWATTE TIMBER STORE</title>
    <link rel="stylesheet" type="text/css" href="CSS/cusCSS/style.css">
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

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timberstoredb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

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
        <a href="cuspurchasehistory.php">Purchase History</a>
        <a class="active" href="cusinvoice.php">Invoice</a>
        <a href="cusmakepayment.html">Make Payment</a>
    </div>

    <div class="container">
        <form method="GET" action="#">
            <div class="form-group">
                <label for="orderId">Order ID</label>
                <input type="text" name="orderId" id="orderId" placeholder="Enter Order ID" required>
            </div>
            <div class = "buttons">
                <button type="submit">View Invoice</button>
            </div>
        </form>
    </div>

    <div class="container">
    <?php
    if (isset($_GET['orderId'])) {
        // Sanitize input
        $orderId = htmlspecialchars($_GET['orderId']);

        // Query to fetch order details and total from finalordertotal
        $sql = "SELECT o.orderid, o.customerid, o.productid, o.quantity, o.price, 
                        f.orderdate, f.totalprice
                FROM orders o
                JOIN finalordertotal f ON o.orderid = f.orderid
                WHERE o.orderid = '$orderId'";

        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $totalPrice = 0;
            // Fetch the first row to get the orderdate and totalprice
            $row = mysqli_fetch_assoc($result);
            $orderDate = $row['orderdate'];
            $totalPrice += $row['totalprice'];  // Add total price from finalordertotal

            echo "<div class='invoice-container'>";
            echo "<p><strong>Invoice for Order ID: $orderId</strong></p>";
            echo "<p><strong>Order Date: </strong>" . $orderDate . "</p>";
            echo "<table border='1' cellpadding='5' cellspacing='0'>";
            echo "<tr><th>Product ID</th><th>Quantity</th><th>Price</th><th>Total</th></tr>";

            // Loop through all orders related to this OrderID
            do {
                $productTotal = $row['quantity'] * $row['price'];
                $totalPrice += $productTotal;

                echo "<tr>";
                echo "<td>" . $row['productid'] . "</td>";
                echo "<td>" . $row['quantity'] . "</td>";
                echo "<td>" . number_format($row['price'], 2) . "</td>";
                echo "<td>" . number_format($productTotal, 2) . "</td>";
                echo "</tr>";
            } while ($row = mysqli_fetch_assoc($result));  // Continue to fetch the next rows

            // Display total price (from both the `orders` table and `finalordertotal`)
            echo "<tr><td colspan='3'><strong>Total Price:</strong></td>";
            echo "<td><strong>" . number_format($totalPrice, 2) . "</strong></td></tr>";
            echo "</table>";
            echo "</div>";
        } else {
            echo "<p class='error-message'>No invoice found for the given Order ID. Please check and try again.</p>";
        }
    }
    ?>
    </div>

</body>
</html>

<?php
$conn->close();
?>
