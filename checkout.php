<?php
session_start();

if (isset($_POST['sub'])) {
    include("include/connect.php");

    $aid = $_SESSION['aid'];
    $add = $_POST['houseadd'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $acc = $_POST['acc'] ?? null;

    // Validate account number if provided
    if (!empty($acc) && (!ctype_digit($acc) || strlen($acc) != 16)) {
        echo "<script>alert('Invalid account number'); setTimeout(function(){ window.location.href = 'checkout.php'; }, 100);</script>";
        exit();
    }

    // Prepare and execute the order query
    $stmt = $con->prepare("INSERT INTO `orders` (dateod, datedel, aid, address, city, country, account, total) VALUES (CURDATE(), NULL, ?, ?, ?, ?, ?, 0)");
    $stmt->bind_param("issss", $aid, $add, $city, $country, $acc);
    $stmt->execute();

    $oid = $stmt->insert_id;

    // Fetch cart items for the user
    $query = "SELECT * FROM cart JOIN products ON cart.pid = products.pid WHERE aid = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $aid);
    $stmt->execute();
    $result = $stmt->get_result();

    $total = 0;
    while ($row = $result->fetch_assoc()) {
        $pid = $row['pid'];
        $cqty = $row['cqty'];
        $price = $row['price'];
        $total += $price * $cqty;

        // Insert into order-details
        $stmt = $con->prepare("INSERT INTO `order-details` (oid, pid, qty) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $oid, $pid, $cqty);
        $stmt->execute();

        // Update product stock
        $stmt = $con->prepare("UPDATE products SET qtyavail = qtyavail - ? WHERE pid = ?");
        $stmt->bind_param("ii", $cqty, $pid);
        $stmt->execute();
    }

    // Clear the cart
    $stmt = $con->prepare("DELETE FROM cart WHERE aid = ?");
    $stmt->bind_param("i", $aid);
    $stmt->execute();

    // Update total in orders
    $stmt = $con->prepare("UPDATE orders SET total = ? WHERE oid = ?");
    $stmt->bind_param("di", $total, $oid);
    $stmt->execute();

    // Redirect to profile
    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ByteBazaar - Checkout</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }

        .input11 {
            display: block;
            width: 100%;
            margin: 20px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn112 {
            background-color: #5cb85c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn112:hover {
            background-color: #4cae4c;
        }

        .table12 {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .table12 th,
        .table12 td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table12 th {
            background-color: #f4f4f4;
        }

        .Yorder {
            margin-top: 20px;
        }

        footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <section id="header">
        <a href="index.php"><img src="img/logo.png" class="logo" alt="Logo" /></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if ($_SESSION['aid'] < 0) { ?>
                    <li><a href='login.php'>Login</a></li>
                    <li><a href='signup.php'>SignUp</a></li>
                <?php } else { ?>
                    <li><a href='profile.php'>Profile</a></li>
                <?php } ?>
                <li><a href="admin.php">Admin</a></li>
                <li id="lg-bag">
                    <a href="cart.php"><i class="far fa-shopping-bag"></i></a>
                </li>
            </ul>
        </div>
    </section>

    <div class="container">
        <h2>Product Order Form</h2>
        <form method="post">
            <input class="input11" type="text" name="houseadd" placeholder="Address" required>
            <input class="input11" type="text" name="city" placeholder="City" required>
            <input class="input11" type="text" name="country" placeholder="Country/State" required>
            <input class="input11" id="account-field" type="text" name="acc" placeholder="Account Number">
            <div>
                <label><input type="radio" name="dbt" value="cod" onchange="showInputBox()"> Cash on Delivery</label>
            </div>
            <div>
                <label><input type="radio" name="dbt" value="bank" checked onchange="showInputBox()"> PayPal/Visa/MasterCard</label>
            </div>
            <button name="sub" type="submit" class="btn112">Place Order</button>
        </form>

        <div class="Yorder">
            <h3>Your Order</h3>
            <table class="table12">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include("include/connect.php");

                    $aid = $_SESSION['aid'];
                    $query = "SELECT * FROM cart JOIN products ON cart.pid = products.pid WHERE aid = $aid";
                    $result = mysqli_query($con, $query);

                    $tot = 0;

                    while ($row = mysqli_fetch_assoc($result)) {
                        $pname = $row['pname'];
                        $cqty = $row['cqty'];
                        $price = $row['price'];
                        $subtotal = $price * $cqty;
                        $tot += $subtotal;

                        echo "<tr><td>$pname x $cqty</td><td>$$subtotal.00</td></tr>";
                    }
                    ?>
                    <tr>
                        <td>Subtotal</td>
                        <td>$$tot.00</td>
                    </tr>
                    <tr>
                        <td>Shipping</td>
                        <td>Free Shipping</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p>2021 ByteBazaar. All rights reserved.</p>
    </footer>

    <script>
        function showInputBox() {
            const select = document.querySelector('input[name="dbt"][value="cod"]');
            const inputBox = document.getElementById("account-field");
            inputBox.style.display = select.checked ? "none" : "block";
        }
    </script>
</body>

</html>
