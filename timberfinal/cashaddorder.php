<!DOCTYPE html>
<html>
<head>
<title>ADD ORDER | NEW SEDAWATTE TIMBER STORE</title>
    <link rel="stylesheet" type="text/css" href="CSS/cusCSS/style.css">
    <link rel="icon" href="IMG/timberlogo.png" type="image/x-icon">
    <style>
        /* Style for the report table */
        .report-section {
            margin-top: 30px;
        }

        .report-section h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #800000;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td strong {
            color: #004d99;
        }
    </style>
</head>
<body>
    <?php
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'timberstoredb');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $message = "";
    $orderID = $customerID = $orderDate = $productID = $price = $quantity = "";

    // Handle adding product to order (Add Product Button)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addProduct'])) {
        $orderID = $_POST['orderID'];
        $customerID = $_POST['customerId'];
        $orderDate = $_POST['orderdate'];
        $productID = $_POST['productId'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
    
        // Only add to orders table if product fields are filled
        if (!empty($productID) && !empty($quantity) && !empty($price)) {
            $total = $price * $quantity;

            // Prepare SQL query to insert into orders table
            $stmt = $conn->prepare("INSERT INTO orders (orderid, customerid, productid, quantity, price) VALUES (?, ?, ?, ?, ?)");
            if ($stmt === false) {
                die("SQL prepare failed: " . $conn->error);
            }

            $stmt->bind_param('iiiii', $orderID, $customerID, $productID, $quantity, $total);
            $exec_result = $stmt->execute();
            if (!$exec_result) {
                die("Execute failed: " . $stmt->error);
            }
            $stmt->close();

            $message = "Product added successfully!";
        } else {
            $message = "Product fields cannot be empty!";
        }

        // Keep OrderID and CustomerID intact after adding product
        $productID = '';
        $customerID = '';
    }

    // Handle adding full total to finalordertotal table (Add Total Button)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addTotalToFinal'])) {
        $orderID = $_POST['orderID'];

        // Fetch total price for the order
        $result = $conn->query("SELECT SUM(price) AS TotalPrice FROM orders WHERE orderid = '$orderID'");
        $row = $result->fetch_assoc();
        $totalPrice = $row['TotalPrice'];

        if ($totalPrice > 0) {
            // Check if the total already exists in finalordertotal
            $checkQuery = $conn->query("SELECT * FROM finalordertotal WHERE orderid = '$orderID'");
            if ($checkQuery->num_rows == 0) {
                // Insert the total into finalordertotal table
                $stmt = $conn->prepare("INSERT INTO finalordertotal (orderid, orderdate, totalprice) VALUES (?, ?, ?)");
                $stmt->bind_param('id', $orderID, $orderDate, $totalPrice); // 'i' for integer, 'd' for decimal
                $stmt->execute();
                $stmt->close();
                $message = "Total added to finalordertotal successfully!";
            } else {
                $message = "Total already exists for this OrderID!";
            }
        } else {
            $message = "No products found for this order. Cannot add total.";
        }
    }

    // Handle generating report (Generate Report Button)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generateReport'])) {
        $orderID = $_POST['orderID'];

        $reportQuery = $conn->query("SELECT o.orderid, p.productname, o.quantity, o.price, f.totalprice
                             FROM orders o
                             JOIN product p ON o.productid = p.productid
                             LEFT JOIN finalordertotal f ON o.orderid = f.orderid
                             WHERE o.orderid = '$orderID'");

        if ($reportQuery->num_rows > 0) {
            $reportData = [];
            while ($row = $reportQuery->fetch_assoc()) {
                $reportData[] = $row;
            }
        } else {
            $reportData = null;
        }
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
        <a href="cashiermain.html">Home</a>
        <a href="cashempcashier.html">Employee</a>
        <a class="active" href="cashaddorder.php">Add Order</a>
        <a href="cashaddcuspayment.html">Payment Process</a>
    </div>

    <div class="container">
        <?php if (!empty($message)) echo "<p class='success'>$message</p>"; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="orderID">Order ID</label>
                <input type="text" name="orderID" placeholder="Enter Order ID" value="<?php echo $orderID; ?>" required>
            </div>
            <div class="form-group">
                <label for="customerId">Customer ID</label>
                <input type="text" name="customerId" placeholder="Enter Customer ID" value="<?php echo $customerID; ?>" required>
            </div>
            <div class="form-group">
                <label for="orderdate">Order Date</label>
                <input type="date" name="orderdate" value="<?php echo $orderDate; ?>" >
            </div>
            <div class="form-group">
                <label for="productId">Select Product</label>
                <select name="productId" id="productId" onchange="showPrice()">
                    <option value="">Select a product</option>
                    <?php
                    // Fetch products from the database
                    $result = $conn->query("SELECT productid, productname, productprice FROM product");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['productid']}' data-price='{$row['productprice']}'>{$row['productname']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" name="price" id="price" value="<?php echo $price; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" value="<?php echo $quantity; ?>">
            </div>
            <div class="buttons">
                <button type="submit" name="addProduct">Add Product</button>
                <button type="submit" name="addTotalToFinal">Add Total to Final Order</button>
                <button type="submit" name="generateReport">Generate Invoice</button>
                <button type="submit" name="goToPayment" onclick="window.location.href='cashaddcuspayment.html'">Go to Payment</button>
            </div>
        </form>

        <?php if (isset($reportData) && $reportData !== null): ?>
        <div class="report-section">
            <h2>Order Report</h2>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>  
                </tr>
                <?php
                $finalTotal = 0; // Variable to store the final total
                foreach ($reportData as $row):
                    $productTotal = number_format($row['quantity'] * $row['price'], 2); // Format to 2 decimal places
                    $finalTotal += $row['quantity'] * $row['price']; // Add to the final total
                ?>
                <tr>
                    <td><?php echo $row['orderid']; ?></td>
                    <td><?php echo $row['productname']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo number_format($row['price'], 2); ?></td> <!-- Display price with 2 decimal places -->
                    <td><?php echo $productTotal; ?></td> <!-- Display product total with 2 decimal places -->
                </tr>
                <?php endforeach; ?>
                <!-- Display Final Total -->
                <tr>
                    <td colspan="4"><strong>Final Total</strong></td>
                    <td><strong><?php echo number_format($finalTotal, 2); ?></strong></td> <!-- Display final total with 2 decimal places -->
                </tr>
            </table>
        </div>
        <?php elseif (isset($reportData) && $reportData === null): ?>
        <p>No data found for this Order ID.</p>
        <?php endif; ?>
    </div>

    <script>
        // This function updates the price field when the product selection changes
        function showPrice() {
            const productSelect = document.getElementById('productId');
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            document.getElementById('price').value = price;
        }
    </script>
</body>
</html>
