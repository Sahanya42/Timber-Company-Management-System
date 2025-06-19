<!DOCTYPE html>
<html>
<head>
    <title>INVENTORY | NEW SEDAWATTE TIMBER STORE</title>
    <link rel="stylesheet" type="text/css" href="CSS/functionCSS/style.css">
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
        <a href="managermain.html">Home</a>
        <a href="manempmanager.html">Employee</a>
        <a href="manaddtask.html">Add Task</a>
        <a class="active" href="manviewinventory.php">View Inventory</a>
        <a href="manreportsales.php">Sales Report</a>
        <a href="mancustomerfeedback.php">Customer Feedback</a>
    </div>

    <div class="container">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "timberstoredb";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            echo "<p class='error-message'>Connection failed: " . $conn->connect_error . "</p>";
            exit;
        }

        $sql = "SELECT productid, productname, productdescription, productprice, addeddate, categoryid FROM product";
        $result = $conn->query($sql);
        ?>
        
        <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Added Date</th>
                <th>Category ID</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row["productid"] ?></td>
                <td><?= $row["productname"] ?></td>
                <td><?= $row["productdescription"] ?></td>
                <td><?= $row["productprice"] ?></td>
                <td><?= $row["addeddate"] ?></td>
                <td><?= $row["categoryid"] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?>
        <p class='error-message'>No products found.</p>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </div>
</body>
</html>
