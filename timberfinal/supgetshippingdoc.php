<!DOCTYPE html>
<html lang="en">

<head>
    <title>REPORTS | NEW SEDAWATTE TIMBER STORE</title>
    <link rel="stylesheet" type="text/css" href="functionstyle.css">
    <link rel="icon" href="timberlogo.png" type="image/x-icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <style>
        body{
            background-image: url('timber.jpg');
            background-repeat: no-repeat; 
            background-size: cover;   
            background-position: center; 
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
        }

        #makepdf {
            box-sizing: content-box;
            width: 80%;
            padding: 30px;
            border: 1px solid black;
            background-color: #f0f0f0;
            text-align: center;
            margin-top: 30px;
        }

        #button {
            background-color: #800000;
            border-radius: 5px;
            color: white;
            padding: 15px 30px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 20px;
        }

        h2 {
            text-align: center;
            font-size: 40px;
            color: #800000;
        }

        table {
            text-align: center;
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
        }

        .header img {
            max-height: 80px;
            margin-bottom: 10px;
        }

        .header h2 {
            font-size: 36px;
        }

        .filters {
            margin-bottom: 20px;
            text-align: right;
        }

        .filters label,
        .filters input {
            margin: 10px;
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
        <a class="active" href="supmakeshipment.html">Make Shipment</a>
        <a href="supsendshippingdoc.html">Send Shipping Document</a>
        <a href="suppackinglist.html">Make Packing List</a>
        <a href="supcreatesupplierinvoice.php">Create Invoice</a>
    </div>

    <div class="container">
        <form method="GET" action="">
            <div class = form-group>
                <label for="suppliershipmentid">Enter Shipment ID:</label>
                <input type="text" id="suppliershipmentid" name="suppliershipmentid" placeholder="e.g., 101" required>
            </div>

            <div class = buttons>
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

    // Check if suppliershipmentid is provided
    $shipment_id = isset($_GET['suppliershipmentid']) ? $_GET['suppliershipmentid'] : null;

    $sql = "SELECT ss.suppliershipmentid, ss.supplierid, s.suppliername, ss.shipmentdate, ss.deliverystatus, ss.deliverydate 
            FROM suppliershipment ss
            JOIN supplier s ON ss.supplierid = s.supplierid";

    if ($shipment_id) {
        $sql .= " WHERE ss.suppliershipmentid = $shipment_id";
    }

    $result = $conn->query($sql);
    ?>

    <div class="container">
        <button id="button">Generate PDF</button>
        <div id="makepdf">
            <div class="header">
                <img src="timberlogo.png" alt="Company Logo">
                <h2>NEW SEDAWATTE TIMBER STORE</h2>
                <p id="reportDate"></p>
            </div>

            <h2>Supplier Shipment Report</h2>
            <table id="orders">
                <thead>
                    <tr>
                        <th>Shipment ID</th>
                        <th>Supplier ID</th>
                        <th>Supplier Name</th>
                        <th>Shipment Date</th>
                        <th>Delivery Status</th>
                        <th>Delivery Date</th>
                    </tr>
                </thead>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['suppliershipmentid']}</td>
                                <td>{$row['supplierid']}</td>
                                <td>{$row['suppliername']}</td>
                                <td>{$row['shipmentdate']}</td>
                                <td>{$row['deliverystatus']}</td>
                                <td>" . ($row['deliverydate'] ? $row['deliverydate'] : "N/A") . "</td>
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
                .save("suppliershipmentreport.pdf");
        });
    </script>
</body>

</html>
