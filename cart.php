<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
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
        .remove-btn {
            display: inline-block;
            padding: 8px;
            background-color: #e74c3c;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .checkout-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2ecc71;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>


<?php
session_start();
include 'db.php';
$userID = $_SESSION['uid'];
$userQuery = "SELECT first_name FROM user_info WHERE user_id = $userID";
$userResult = $con->query($userQuery);

if ($userResult->num_rows > 0) {
    $userData = $userResult->fetch_assoc();
    $userName = $userData['first_name'];
} else {
    $userName = "User";
}

// Fetch user's cart items
$cartQuery = "SELECT * FROM cart WHERE userid = $userID";
$cartResult = $con->query($cartQuery);

if ($cartResult->num_rows > 0) {
    echo "<div class='container'>";
    echo "<h2>Hello, $userName! Here are your cart items:</h2>";
    
    echo "<table>";
    echo "<tr><th>Product</th><th>Price</th><th>Action</th></tr>";

    $totalPrice = 0;

    while ($row = $cartResult->fetch_assoc()) {
        $productName = $row['pname'];
        $productPrice = $row['pprice'];
        $productID = $row['pid'];

        echo "<tr><td>$productName</td><td>$productPrice</td><td><a class='remove-btn' href='remove_item.php?pid=$productID&userid=$userID'>Remove</a></td></tr>";

        $totalPrice += $productPrice;
    }

    echo "</table>";

    echo "<p class='total-price' id='$totalPrice'>Total Price: $totalPrice</p>";
   // Add checkout link with JavaScript function
    echo "<a class='checkout-btn pay-btn' id='$userID' href='javascript:void(0);' >Proceed to Checkout</a>";

    echo "</div>";

    // JavaScript function for checkout
    // echo "<script>";
    // echo "function checkout(userID) {";
    // echo "var phone = prompt('Enter your phone number:');";
    // echo "var location = prompt('Enter your pickup location:');";
    // echo "if (phone && location) {";
    // echo "window.location.href = 'checkout.php?userid=' + userID + '&phone=' + phone + '&location=' + location;";
    // echo "}";
    // echo "}";
    // echo "</script>";
} else {
    echo "<div class='container'>";
    echo "<p>Your cart is empty.</p>";
    echo "</div>";
}

$con->close();
?>

<script>
    async function sfetch() {
        var phone = prompt('Enter your phone number:')
        var total = document.querySelector('.total-price').id;
        console.log('total: '+total);
        let order = {
            order: [{ desc: '', id: 6, image: '', name: '', price: 1, qty: 1 }],
            phone: phone,
            total: total
        };

        const _response = await fetch("api/stk.php", {
            method: 'post',
            headers: { 'content-type': 'application/json', 'accept': 'application/json'},
            body: JSON.stringify(order)
        })

        if(_response.status === 200) {
            const res = await _response.json()

            var interval;

            let startTime = new Date().getTime()
            let stopTime = new Date().getTime() + 25000;
            let orderid = res.orderid
            let stkreqres = res.stkreqres.CheckoutRequestID


            const callback = async () => {
                let now = new Date().getTime()

                if(now > stopTime){
                    clearInterval(interval)
                    alert("Your payment session has timed out")
                    return
                }

                // method 1
                // const poll = await fetch('api/orders/' + orderid + '-payment.json')

                // if(poll.status == 200) {
                //     const _poll = await poll.json()
                //     const { Body } = _poll

                //     if(Body.stkCallback.ResultCode !== 0){
                //         alert(Body.stkCallback.ResultDesc)
                //     }
                //     if(Body.stkCallback.ResultCode === 0){
                //         alert(Body.stkCallback.ResultDesc)
                //         window.location.reload()
                //     }
                //     clearInterval(interval)
                // } 

                // method 2
                const _poll = await fetch('api/polling.php?id=' + stkreqres)

                if(_poll.status === 200) {
                    const _res = await _poll.json()

                    if(_res.errorCode){}
                    else if(_res.ResultCode && _res.ResultCode == 0) {
                        clearInterval(interval)
                        alert(_res.ResultDesc)
                        window.location.reload()
                    } else if(_res.ResultCode && _res.ResultCode != 0) {
                        clearInterval(interval)
                        alert(_res.ResultDesc)
                    }
                    console.log(_res)
                }

                if(_poll.status >= 500) {
                    clearInterval(interval)
                    alert("Sorry we encountered an error")
                }
            }

            interval = setInterval(callback, 2000)

        } else {
            $("#err").html(`<p class="alert alert-danger">${_response.statusText}</p>`)
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Wait for the DOM to be fully loaded

        // Get the button by its class
        var btn = document.querySelector('.pay-btn');


        // Add a click event listener to the button
        btn.addEventListener('click', function () {
            btn.setAttribute("disabled", true)

            console.log("paying");
            btn.disabled = true
            sfetch().then(() => {
                alert('Please confirm that you have paid!')
                var location = prompt('Enter your pickup location:');
                window.location.href = 'checkout.php?userid=' + userID + '&phone=' + phone + '&location=' + location;
                console.log('hi')});
                
        });
    });
</script>

</body>
</html>