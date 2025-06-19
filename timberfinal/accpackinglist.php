<!DOCTYPE html>
<html lang="en">

<head>
    <title>PACKING LIST | NEW SEDAWATTE TIMBER STORE</title>
    <link rel="stylesheet" type="text/css" href="functionstyle.css">
    <link rel="icon" href="IMG/timberlogo.png" type="image/x-icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 50px;
            position: relative;
        }

        #makepdf {
            box-sizing: content-box;
            width: 80%;
            padding: 30px;
            border: 1px solid black;
            background-color: #f0f0f0;
            text-align: center;
            margin: 0 auto;
            margin-top: 60px;
        }

        #button {
            background-color: #800000;
            border-radius: 5px;
            color: white;
            padding: 15px 30px;
            font-size: 18px;
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 10px;
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

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        .header img {
            max-height: 80px;
            margin-bottom: 10px;
        }

        .header h2 {
            font-size: 36px;
            color: white;
        }

        .header p {
            font-size: 18px;
            color: #555;
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

    $sql = "SELECT supplierpackinglistid, createdate, quantity, totalamt FROM supplierpackinglist";
    $result = $conn->query($sql);
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
        <a class="active" href="accfromsupplier.html">From Supplier</a>
        <a href="accreportfinance.php">Create Report</a>
        <a href="accsuppay.html">Make Supplier Payment</a>
        <a href="acccreatesalaries.html">Salaries</a>
        <a href="acccuspayments.php">Customer Payments</a>
    </div>

    <div class="container">
        <button id="button">Generate PDF</button>
        <div id="makepdf">
            <div class="header">
                <img src="IMG/timberlogo.png" alt="Company Logo">
                <h2>NEW SEDAWATTE TIMBER STORE</h2>
                <p id="reportDate"></p>
            </div>

            <h2>Packing List</h2>
            <table id="packinglist">
                <thead>
                    <tr>
                        <th>Packing List ID</th>
                        <th>Create Date</th>
                        <th>Quantity</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['supplierpackinglistid']}</td>
                                <td>{$row['createdate']}</td>
                                <td>{$row['quantity']}</td>
                                <td align='right'>{$row['totalamt']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No data available</td></tr>";
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
                .save("packinglistreport.pdf");
        });
    </script>
</body>
</html>
