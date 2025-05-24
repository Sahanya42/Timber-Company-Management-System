<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'timberstoredb';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customerid = $_POST['customerid'];
$cosamount = $_POST['amount'];
$cuspaymentmethods = $_POST['paymentmethod'];
$cuscardnumber = isset($_POST['cardnumber']) ? $_POST['cardnumber'] : null;
$cuscardexpiry = isset($_POST['cardexpiry']) ? $_POST['cardexpiry'] : null;
$cuscardcvv = isset($_POST['cardcvv']) ? $_POST['cardcvv'] : null;
$cuschequenumber = isset($_POST['chequenumber']) ? $_POST['chequenumber'] : null;
$cusbankname = isset($_POST['bankname']) ? $_POST['bankname'] : null;

$sql = "INSERT INTO customerpayments (customerid, cosamount, cuspaymentmethods, cuscardnumber, cuscardexpiry, cuscardcvv, cuschequenumber, cusbankname)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("sdssssss", $customerid, $cosamount, $cuspaymentmethods, $cuscardnumber, $cuscardexpiry, $cuscardcvv, $cuschequenumber, $cusbankname);

if ($stmt->execute()) {
    $message = "Payment recorded successfully!";
} else {
    $message = "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Status</title>
    <script>
        const message = <?php echo json_encode($message); ?>;
        alert(message);
        window.history.back();
    </script>
</head>
<body></body>
</html>
