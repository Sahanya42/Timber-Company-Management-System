<!DOCTYPE html>
<html>
<head>
    <title>PACKING LIST | NEW SEDAWATTE TIMBER STORES</title>
    <link rel="stylesheet" type="text/css" href="supplierstyle.css">
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
        <a href="supcheckpayments.php">Check Payment</a>
        <a href="supmakeshipment.html">Make Shipment</a>
        <a href="supsendshippingdoc.html">Send Shipping Document</a>
        <a class="active" href="suppackinglist.html">Make Packing List</a>
        <a href="supcreatesupplierinvoice.php">Create Invoice</a>
    </div>

    <div class="container">
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "timberstoredb"; 

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM supplierpackinglist";
            $result = $conn->query($sql);
        ?>

        <table>
            <tr>
                <th>Packing List ID</th>
                <th>Created Date</th>
                <th>Quantity</th>
                <th>Total Amount</th>
            </tr>

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["supplierpackinglistid"] . "</td>
                            <td>" . $row["createdate"] . "</td>
                            <td>" . $row["quantity"] . "</td>
                            <td>" . $row["totalamt"] . "</td>
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
