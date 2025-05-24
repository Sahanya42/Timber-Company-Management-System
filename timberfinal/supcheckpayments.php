<!DOCTYPE html>
<html>
<head>
    <title>PAYMENTS | NEW SEDAWATTE TIMBER STORES</title>
    <link rel = "stylesheet" type = "text/css" href = "supplierstyle.css">
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
        <a class="active" href="supcheckpayments.php">Check Payment</a>
        <a href="supmakeshipment.html">Make Shipment</a>
        <a href="supsendshippingdoc.html">Send Shipping Document</a>
        <a href="suppackinglist.html">Make Packing List</a>
        <a href="supcreatesupplierinvoice.php">Create Invoice</a>
    </div>

    <div class="container">
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "timberstoredb";
    
        $conn = new mysqli($servername, $username, $password, $dbname);
    

        // Fetch required payment records from the supplierpayments table
        $sql = "SELECT supplierpaymentis, compamount, comppaymentmethod, comppaymentdate FROM supplierpayments";
        $result = $conn->query($sql);
    ?>
    <table>
        <tr>
            <th>Payment ID</th>
            <th>Amount</th>
            <th>Payment Method</th>
            <th>Payment Date</th>
        </tr>

        <?php
        // Check if there are any records and output them
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["supplierpaymentis"] . "</td>
                        <td>" . $row["compamount"] . "</td>
                        <td>" . $row["comppaymentmethod"] . "</td>
                        <td>" . $row["comppaymentdate"] . "</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No records found!</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    </div>
</body>
</html>
