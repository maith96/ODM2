<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .button-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<?php
session_start();



include 'db.php';

$ordersQuery = "SELECT * FROM orders WHERE userid";
$ordersResult = $con->query($ordersQuery);

echo "<div class='container'>";
echo "<h2>Hello, Admin  Here are the orders:</h2>";

if ($ordersResult->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Order ID</th><th>Product</th><th>Price</th></tr>";

    while ($row = $ordersResult->fetch_assoc()) {
        $orderID = $row['orderid'];
        $productName = $row['pname'];
        $productPrice = $row['pprice'];

        echo "<tr><td>$orderID</td><td>$productName</td><td>$productPrice</td></tr>";
    }

    echo "</table>";
    echo "<a class='button-link' href='home.php'>BACK</a>";
} else {
    echo "<p>You have no orders.</p>";
}

echo "</div>";

// Close the database connection
$con->close();
?>

</body>
</html>