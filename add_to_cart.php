<?php
session_start();
include 'db.php';

if(isset($_GET['pid'])) {
    // Assuming you have user authentication in place, retrieve the user ID
    $userId = $_SESSION['uid']; // Replace with your actual session variable
    
    
    $pid = $_GET['pid'];
    $pname=$_GET['pname'];
    $pprice=$_GET['pprice'];
    $pimage=$_GET['pimage'];
    
  // Your SQL query to insert values into the table
$sql = "INSERT INTO cart (pid, userid, pname, pprice, pimage) VALUES ('$pid', '$userId', '$pname', '$pprice', '$pimage')";

if (mysqli_query($con, $sql)) {
    // Product added successfully, now display JavaScript alert and redirect
    echo "<script>alert('Product added to cart successfully'); window.location.href = 'index.php';</script>";
} else {
    // Handle the case where the product was not added to the cart
    echo "<script>alert('Failed to add product to cart'); window.location.href = 'index.php';</script>";
}
}
?>