<!DOCTYPE html>
<html lang="en">

<head>
    <title>REPORTS | NEW SEDAWATTE TIMBER STORE</title>
    <link rel="stylesheet" type="text/css" href="functionstyle.css">
    <link rel="icon" href="timberlogo.png" type="image/x-icon">
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

        h2{
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

        .filters {
            text-align: center;
            margin-bottom: 20px;
        }

        .filters input, .filters select {
            margin: 10px;
            padding: 5px;
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
        <a href="managermain.html">Home</a>
        <a href="manempmanager.html">Employee</a>
        <a href="manaddtask.html">Add Task</a>
        <a href="manviewinventory.php">View Inventory</a>
        <a class="active" href="manreportsales.php">Sales Report</a>
        <a href="mancustomerfeedback.php">Customer Feedback</a>
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

    // Retrieve date range from the form
    $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
    $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;

    // Prepare the query
    $sql = "SELECT orderid, orderdate, totalprice FROM finalordertotal";

    if ($start_date && $end_date) {
        $sql .= " WHERE addeddate BETWEEN '$start_date' AND '$end_date'";
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

            <h2>Sales Report</h2>
            <table id="orders">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['orderid']}</td>
                                <td>{$row['orderdate']}</td>
                                <td align='right'>{$row['totalprice']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No data available</td></tr>";
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
                .save("managersalesreport.pdf"); 
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
