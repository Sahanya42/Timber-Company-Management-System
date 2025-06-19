<!DOCTYPE html>
<html lang="en">

<head>
    <title>REPORTS | NEW SEDAWATTE TIMBER STORE</title>
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

    <div class="header">
        <div class="back-button">
            <a href="javascript:history.back()">&#10096; Back</a>
        </div>
        NEW SEDAWATTE TIMBER STORES
        <button class="logout-btn" onclick="window.location.href='1main.html'">LOGOUT</button>
    </div>

    <div class="tabs">
        <a href="stockmanagermain.html">Home</a>
        <a href="stmanempstockmanager.html">Employee</a>
        <a href="stmanaddwoodcategories.html">Wood Categories</a>
        <a href="stmanmanageinventory.html">Inventory</a>
        <a href="stmanaddproduct.htmlstmanaddnewproduct.php">Manage Product</a>
        <a href="stmanviewshipment.php">View Shipment</a>
        <a class="active" href="stmanreportinventory.php">Create Inventory Report</a>
    </div>

    <div class="container">
        <form method="" action="">
            <div class= "form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>
            </div>

            <div class= "form-group">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" required>
            </div>
            
            <div class= "buttons">
                <button type="submit" id="filter">Generate Filtered Report</button>
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

    //$sql = "SELECT productid, productname, productdescription, productprice, addeddate, categoryid FROM product";

    // Retrieve date range from the form
    $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
    $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;

    // Prepare the query
    $sql = "SELECT productid, productname, productdescription, productprice, addeddate, categoryid FROM product";

    if ($start_date && $end_date) {
        $sql .= " WHERE addeddate BETWEEN '$start_date' AND '$end_date'";
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

            <h2>Inventory Report</h2>
            <table id="products">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Added Date</th>
                        <th>Category ID</th>
                    </tr>
                </thead>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['productid']}</td>
                                <td>{$row['productname']}</td>
                                <td>{$row['productdescription']}</td>
                                <td align='right'>{$row['productprice']}</td>
                                <td>{$row['addeddate']}</td>
                                <td>{$row['categoryid']}</td>
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
                .save("inventoryreport.pdf");
        });

        document.querySelector('form').addEventListener('submit', function (event) {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
                alert("The start date cannot be later than the end date.");
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
