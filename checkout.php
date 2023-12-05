<?php
// Include your database connection
include 'db.php';

// Get user input
$userID = $_GET['userid'];
$phone = $_GET['phone'];
$location = $_GET['location'];

// Generate a random orderid
$orderid = 'ODM' . rand(200, 5000);

// Insert order details into orders table
$insertOrderQuery = "INSERT INTO orders (orderid, userid, pname, pprice, pimage, contact, location) SELECT '$orderid', userid, pname, pprice, pimage, '$phone', '$location' FROM cart WHERE userid = ?";

// Prepare and execute the query
$stmt = $con->prepare($insertOrderQuery);
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->close();

// Delete items from the cart table
$deleteItemsQuery = "DELETE FROM cart WHERE userid = ?";

$stmt = $con->prepare($deleteItemsQuery);
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->close();

// Close the database connection
$con->close();
?>

<script>
alert("Order successful!");
window.location.href = "index.php";
</script>