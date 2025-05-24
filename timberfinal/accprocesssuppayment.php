<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'timberstoredb';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$supplierid = $_POST['supplierid'];
$compamount = $_POST['amount'];
$comppaymentmethod = $_POST['paymentmethod'];
$compcardnumber = isset($_POST['cardnumber']) ? $_POST['cardnumber'] : null;
$compcardexpiry = isset($_POST['cardexpiry']) ? $_POST['cardexpiry'] : null;
$compcardcvv = isset($_POST['cardcvv']) ? $_POST['cardcvv'] : null;
$compchequenumber = isset($_POST['chequenumber']) ? $_POST['chequenumber'] : null;
$compbankname = isset($_POST['bankname']) ? $_POST['bankname'] : null;

$sql = "INSERT INTO supplierpayments (supplierid, compamount, comppaymentmethod, compcardnumber, compcardexpiry, compcardcvv, compchequenumber, compbankname)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("idssssss", $supplierid, $compamount, $comppaymentmethod, $compcardnumber, $compcardexpiry, $compcardcvv, $compchequenumber, $compbankname);

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
        // Pass the PHP message to JavaScript
        const message = <?php echo json_encode($message); ?>;
        alert(message);
        window.history.back();
    </script>
</head>
<body></body>
</html>
