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
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ByteBazaar</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />

    <link rel="stylesheet" href="style.css" />

    <style>
        #account-field {
            display: block;
        }

        .hidden {
            display: none;
        }
        .input11 {
  display: block;
  width: 80%;
  margin: 40px auto;
  padding: 10px 5px;
  border: none;
  border-bottom: 0.01rem dimgray solid;
  outline: none;
}

.table12 {
  margin: 0;
  padding: 0;
  width: 100%;
  overflow: auto;
}

.table12 tr{
    width: 100%;
  overflow: auto;

}

    </style>

</head>

<body>
    <section id="header">
        <a href="index.php"><img src="img/logo.png" class="logo" alt="" /></a>

        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>

                <?php

                if ($_SESSION['aid'] < 0) {
                    echo "   <li><a href='login.php'>login</a></li>
            <li><a href='signup.php'>SignUp</a></li>
            ";
                } else {
                    echo "   <li><a href='profile.php'>profile</a></li>
          ";
                }
                ?>
                <li><a href="admin.php">Admin</a></li>
                <li id="lg-bag">
                    <a href="cart.php"><i class="far fa-shopping-bag"></i></a>
                </li>
                <a href="#" id="close"><i class="far fa-times"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.php"><i class="far fa-shopping-bag"></i></a>
            <i id="bar" class="fas fa-outdent"></i>
        </div>
    </section>

    <div class="container">
        <div class="titlecheck">
            <h2>Product Order Form</h2>
        </div>
        <div class="d-flex">
            <form method="post" id="form1">

                <h3 style="color: darkred; margin: auto"></h3>
                <input class="input11" type="text" name="houseadd" placeholder="Address" required>
                <input class="input11" type="text" name="city" placeholder="City" required>
                <input class="input11" type="text" name="country" placeholder="County/State" required>
                <input class="input11" id="account-field" type="text" name="acc" placeholder="Account Number">
                <div>
                    <input class="input2" type="radio" id="ac1" name="dbt" value="cod" onchange="showInputBox()"> Cash
                    on Delivery
                </div>
                <div>
                    <input class="input2" type="radio" id="ac2" name="dbt" value="bank" checked
                        onchange="showInputBox()"> Paypal/Visa/MasterCard <span>
                        <img src="img/pay/pay.png" alt="">
                    </span>
                </div>
                <button name="sub" type="submit" class="btn112">Place Order</button>
            </form>
            <div class="Yorder">
                <table class="table12">
                    <tr class='tr1'>
                        <th class='th1' colspan='2'>Your order</th>
                    </tr>

                    <?php
                    include("include/connect.php");

                    $aid = $_SESSION['aid'];

                    $query = "SELECT * FROM cart JOIN products ON cart.pid = products.pid WHERE aid = $aid";

                    $result = mysqli_query($con, $query);

                    global $tot;

                    while ($row = mysqli_fetch_assoc($result)) {
                        $pid = $row['pid'];
                        $pname = $row['pname'];
                        $desc = $row['description'];
                        $qty = $row['qtyavail'];
                        $price = $row['price'];
                        $cat = $row['category'];
                        $img = $row['img'];
                        $brand = $row['brand'];
                        $cqty = $row['cqty'];
                        $a = $price * $cqty;
                        $tot = $tot + $a;

                        echo "
            
            <tr class='tr1'>
              <td class='td1'>$pname x $cqty(Qty)</td>
              <td class='td1'>$a</td>
            </tr>

              ";
                    }
                    echo "
            <tr class='tr1'>
            <td class='td1'>Subtotal</td>
            <td class='td1'>$$tot.00</td>
          </tr>
          <tr class='tr1'>
            <td class='td1'>Shipping</td>
            <td class='td1'>Free shipping</td>
          </tr>";
                    ?>


                </table><br>
            </div><!-- Yorder -->
        </div>
    </div>

    <footer class="section-p1">
        <div class="col">
            <img class="logo" src="img/logo.png" />
            <h4>Contact</h4>
            <p>
                <strong>Address: </strong> Street 2, Johar Town Block A,Lahore

            </p>
            <p>
                <strong>Phone: </strong> +92324953752
            </p>
            <p>
                <strong>Hours: </strong> 9am-5pm
            </p>
        </div>

        <div class="col">
            <h4>My Account</h4>
            <a href="cart.php">View Cart</a>
            <a href="wishlist.php">My Wishlist</a>
        </div>
        <div class="col install">
            <p>Secured Payment Gateways</p>
            <img src="img/pay/pay.png" />
        </div>
        <div class="copyright">
            <p>2021. byteBazaar. HTML CSS </p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>

</html>

<script>
    function showInputBox() {
        var select = document.querySelector('#ac1');
        var inputBox = document.getElementById("account-field");
        if (!select.checked) {
            inputBox.style.display = "block";
        } else {
            inputBox.style.display = "none";
        }
    }
</script>

<script>
window.addEventListener("unload", function() {
  // Call a PHP script to log out the user
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "logout.php", false);
  xhr.send();
});
</script>
