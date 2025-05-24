<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "timberstoredb");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $orderID = $_POST['orderID'];
    $customerID = $_POST['customerId'];
    $orderDate = $_POST['orderdate'];
    $items = json_decode($_POST['items'], true);

    $totalAmount = 0;

    foreach ($items as $item) {
        $productID = $item['productId'];
        $price = $item['price'];
        $quantity = $item['quantity'];
        $total = $price * $quantity;
        $totalAmount += $total;

        $stmt = $conn->prepare("INSERT INTO orders (orderid, customerid, productid, quantity, price) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiii", $orderID, $customerID, $productID, $quantity, $price);
        $stmt->execute();
    }

    $stmt = $conn->prepare("INSERT INTO finalordertotal (orderid, orderdate, totalprice) VALUES (?, ?, ?)");
    $stmt->bind_param("isd", $orderID, $orderDate, $totalAmount);
    $stmt->execute();

    $conn->close();
    header("Location: cusplaceneworder.php?orderID=" . $orderID);
}
?>
