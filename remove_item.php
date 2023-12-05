<?php
// Include your database connection
include 'db.php';

// Get pid and userid from the URL parameters
$pid = $_GET['pid'];
$userid = $_GET['userid'];

// Delete the item from the cart table
$deleteItemQuery = "DELETE FROM cart WHERE pid = ? AND userid = ?";

// Prepare and execute the query
$stmt = $con->prepare($deleteItemQuery);
$stmt->bind_param("ii", $pid, $userid);
$stmt->execute();
$stmt->close();

// Close the database connection
$con->close();

// Display alert and redirect back to cart.php using JavaScript
echo "<script>
    alert('Item removed successfully');
    window.location.href = 'cart.php';
</script>";
?>