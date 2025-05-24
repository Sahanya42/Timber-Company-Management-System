<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timberstoredb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $productid = $_POST['product_id'] ?? null;
    $productname = $_POST['product_name'] ?? null;
    $productdescription = $_POST['description'] ?? null;
    $productprice = $_POST['price'] ?? null;
    $categoryid = $_POST['category_id'] ?? null;

    // Validate product ID as integer
    if ($productid && !filter_var($productid, FILTER_VALIDATE_INT)) {
        echo "<script>alert('Invalid Product ID format. Please enter a valid number.');</script>";
    } else {
        $stmt = null;

        // Handle actions
        if ($action === "add") {
            $sql = "INSERT INTO product (productid, productname, productdescription, productprice, categoryid) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("issdi", $productid, $productname, $productdescription, $productprice, $categoryid);
            }
        } elseif ($action === "update") {
            $sql = "UPDATE product SET productname = ?, productdescription = ?, productprice = ?, categoryid = ? 
                    WHERE productid = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ssdii", $productname, $productdescription, $productprice, $categoryid, $productid);
            }
        } elseif ($action === "delete") {
            $sql = "DELETE FROM product WHERE productid = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("i", $productid);
            }
        }

        // Execute the query
        if ($stmt) {
            if ($stmt->execute()) {
                echo "<script>alert('Product " . ($action === 'add' ? 'added' : ($action === 'update' ? 'updated' : 'deleted')) . " successfully.'); window.location.href='stmanaddnewproduct.php';</script>";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing SQL statement: " . $conn->error;
        }
    }
}

$conn->close();
?>
