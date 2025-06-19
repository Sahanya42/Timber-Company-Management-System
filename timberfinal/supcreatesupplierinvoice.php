<!DOCTYPE html>
<html>
<head>
    <title>INVOICE | NEW SEDAWATTE TIMBER STORES</title>
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
        <a href="suppackinglist.html">Make Packing List</a>
        <a class="active" href="supcreatesupplierinvoice.php">Create Invoice</a>
    </div>

    <div class="container">
        <form method="GET" action="">
            <div class="form-group">
                <label for="supplierpackinglistid">Enter Packing List ID:</label>
                <input type="text" id="supplierpackinglistid" name="supplierpackinglistid" placeholder="e.g., 101" required>
            </div>

            <div class="buttons">
                <button type="submit" id="filter">Generate Report</button>
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

    // Check if supplierpackinglistid is provided
    $packing_list_id = isset($_GET['supplierpackinglistid']) ? $_GET['supplierpackinglistid'] : null;

    $sql = "SELECT spl.supplierpackinglistid, spl.supplierid, s.suppliername, spl.createdate, spl.quantity, spl.totalamt 
            FROM supplierpackinglist spl
            JOIN supplier s ON spl.supplierid = s.supplierid";

    if ($packing_list_id) {
        $sql .= " WHERE spl.supplierpackinglistid = $packing_list_id";
    }

    $result = $conn->query($sql);
    ?>

    <div class="container">
        <button id="button">Generate PDF</button>
        <div id="makepdf">
            <div class="header">
                <img src="IMG/timberlogo.png" alt="Company Logo">
                <h2>NEW SEDAWATTE TIMBER STORE</h2>
                <p id="reportDate"></p>
            </div>
            
            <table id="orders">
                <thead>
                    <tr>
                        <th>Packing List ID</th>
                        <th>Supplier ID</th>
                        <th>Supplier Name</th>
                        <th>Created Date</th>
                        <th>Quantity</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['supplierpackinglistid']}</td>
                                <td>{$row['supplierid']}</td>
                                <td>{$row['suppliername']}</td>
                                <td>{$row['createdate']}</td>
                                <td>{$row['quantity']}</td>
                                <td>{$row['totalamt']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No data available</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>

    <script>
        let button = document.getElementById("button");
        let makepdf = document.getElementById("makepdf");

        let currentDate = new Date();
        let formattedDate = currentDate.toLocaleString();

        document.getElementById("reportDate").textContent = "Report generated on: " + formattedDate;

        button.addEventListener("click", function () {
            html2pdf()
                .from(makepdf)
                .save("supplierpackinglistreport.pdf");
        });
    </script>
</body>
</html>
