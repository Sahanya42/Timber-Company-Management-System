<!DOCTYPE html>
<html>
<head>
    <title>SHIPPING DOCUMENT | NEW SEDAWATTE TIMBER STORE</title>
    <link rel="stylesheet" type="text/css" href="workstyle.css">
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
        <a href="deliverymanager.html">Home</a>
        <a href="delmanempdeliverymanager.html">Employee</a>
        <a href="delmancreateshipdoc.html">Create Shipping Document</a>
        <a class="active" href="delmanviewshipdoc.php">View Shipping Document</a>
        <a href="delmancreatepackinglist.html">Create Packing List</a>
        <a href="delmanviewpackinglist.php">View Packing List</a>
        <a href="delmanvieworders.php">View Orders</a>    
    </div>

    <div class="container">
        <form method="GET" action="#">
            <div class="form-group">
                <label for="shipdocid">Shipping Document ID</label>
                <input type="text" name="shipdocid" placeholder="Enter Shipping Document ID" required>
            </div>
            <div class="buttons">
                <button type="submit">View Shipping Document</button>
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

    if (isset($_GET['shipdocid'])) {
        $shipdocid = $_GET['shipdocid'];

        $sql = "SELECT * FROM compshippingdocument WHERE compshippingdocumentid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $shipdocid);
        $stmt->execute();
        $result = $stmt->get_result();
    ?>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Shipping Document ID</th>
                    <th>Carrier Name</th>
                    <th>Date Issued</th>
                    <th>Tracking Number</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $row['compshippingdocumentid']; ?></td>
                        <td><?php echo $row['compcarrier']; ?></td>
                        <td><?php echo $row['compdateissued']; ?></td>
                        <td><?php echo $row['comptrackingnumber']; ?></td>
                    </tr>
                <?php
                    }
                } else {
                ?>
                    <tr>
                        <td colspan="4" class="error-message">No records found for the given Shipping Document ID.</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
    }
    $conn->close();
    ?>
</body>
</html>
