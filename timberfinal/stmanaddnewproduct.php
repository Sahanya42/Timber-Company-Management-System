<!DOCTYPE html>
<html>
<head>
    <title>ADD PRODUCT | NEW SEDAWATTE TIMBER STORE</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="timberlogo.png" type="image/x-icon">

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
        <a class="active" href="stmanaddnewproduct.php">Manage Product</a>
        <a href="stmanviewshipment.php">View Shipment</a>
        <a href="stmanreportinventory.php">Create Inventory Report</a>
    </div>

    <div class = "container">
        <form action="stmanaddproduct.php" method="POST">
            <div class="form-group">
                <label for="product-id">Product ID</label>
                <input type="text" name="product_id" placeholder="Enter Product ID" required><br><br>
            </div>
    
            <div class="form-group">
                <label for="product-name">Product Name</label>
                <input type="text" name="product_name" placeholder="Enter Product Name" required><br><br>
            </div>
    
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" placeholder="Enter Product Description" required></textarea><br><br>
            </div>
    
            <div class="form-group">
                <label for="price">Price (LKR)</label>
                <input type="number" name="price" step="0.01" placeholder="Enter Price" required><br><br>
            </div>
            
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category_id" required>
                    <option value="" disabled selected>Select a Category</option>
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "timberstoredb";
            
                    $conn = new mysqli($servername, $username, $password, $dbname);
            
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
            
                    $sql = "SELECT categoryid, categoryname FROM woodtypecategories";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['categoryid'] . "'>" . $row['categoryname'] . "</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No Categories Available</option>";
                    }
            
                    // Close connection
                    $conn->close();
                    ?>
                </select>
            </div>
            
            <div class="buttons">
                <button type="submit" name="action" value="add">Add Product</button>
                <button type="submit" name="action" value="update">Update Product</button>
                <button type="submit" name="action" value="delete">Delete Product</button>
            </div>
        </form>
        <a href="stmanviewproduct.php" target="_blank" class="view-button">VIEW</a>
    </div>
</body>
</html>
