<?php
session_start();

// Aktifkan error reporting untuk debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Periksa apakah sesi valid
if (!isset($_SESSION['aid'])) {
    die("Session expired. Please log in again.");
}

if (isset($_POST['sub'])) {
    // Pastikan file koneksi ada
    if (!file_exists("include/connect.php")) {
        die("Database configuration file not found.");
    }

    include("include/connect.php");

    // Ambil nilai input dengan sanitasi
    $aid = $_SESSION['aid'];
    $add = htmlspecialchars(trim($_POST['houseadd']), ENT_QUOTES, 'UTF-8');
    $city = htmlspecialchars(trim($_POST['city']), ENT_QUOTES, 'UTF-8');
    $country = htmlspecialchars(trim($_POST['country']), ENT_QUOTES, 'UTF-8');
    $acc = htmlspecialchars(trim($_POST['acc']), ENT_QUOTES, 'UTF-8');
    $totalOrder = 0;

    // Validasi input alamat
    if (empty($add) || empty($city) || empty($country)) {
        die("Address, City, and Country fields are required.");
    }

    // Validasi nomor akun jika diisi
    if (!empty($acc) && (!ctype_digit($acc) || strlen($acc) != 16)) {
        echo "<script>alert('Invalid account number. It must be a 16-digit number.');</script>";
        echo "<script>window.location.href = 'checkout.php';</script>";
        exit();
    }

    // Insert ke tabel orders
    $query = "INSERT INTO `orders` (dateod, datedel, aid, address, city, country, account, total) 
              VALUES (CURDATE(), NULL, '$aid', '$add', '$city', '$country', '$acc', 0)";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Error inserting order: " . mysqli_error($con));
    }

    // Ambil ID pesanan yang baru dibuat
    $oid = mysqli_insert_id($con);

    // Ambil data dari cart
    $query = "SELECT * FROM cart JOIN products ON cart.pid = products.pid WHERE aid = $aid";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Error fetching cart data: " . mysqli_error($con));
    }

    // Proses setiap item di cart
    while ($row = mysqli_fetch_assoc($result)) {
        $pid = $row['pid'];
        $cqty = $row['cqty'];
        $price = $row['price'];
        $qtyAvail = $row['qtyavail'];
        $totalItem = $price * $cqty;

        // Validasi stok
        if ($qtyAvail < $cqty) {
            die("Insufficient stock for product ID $pid.");
        }

        // Insert ke tabel order-details
        $query = "INSERT INTO `order-details` (oid, pid, qty) VALUES ($oid, $pid, $cqty)";
        if (!mysqli_query($con, $query)) {
            die("Error inserting order details: " . mysqli_error($con));
        }

        // Update stok produk
        $query = "UPDATE products SET qtyavail = qtyavail - $cqty WHERE pid = $pid";
        if (!mysqli_query($con, $query)) {
            die("Error updating product stock: " . mysqli_error($con));
        }

        // Tambahkan ke total pesanan
        $totalOrder += $totalItem;
    }

    // Hapus cart pengguna
    $query = "DELETE FROM cart WHERE aid = $aid";
    if (!mysqli_query($con, $query)) {
        die("Error clearing cart: " . mysqli_error($con));
    }

    // Update total pada tabel orders
    $query = "UPDATE orders SET total = $totalOrder WHERE oid = $oid";
    if (!mysqli_query($con, $query)) {
        die("Error updating order total: " . mysqli_error($con));
    }

    // Redirect ke halaman profile
    header("Location: profile.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ByteBazaar</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" href="style.css">

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
    </style>
</head>

<body>
    <section id="header">
        <a href="index.php"><img src="img/logo.png" class="logo" alt=""></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if ($_SESSION['aid'] < 0): ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="signup.php">SignUp</a></li>
                <?php else: ?>
                    <li><a href="profile.php">Profile</a></li>
                <?php endif; ?>
                <li><a href="admin.php">Admin</a></li>
                <li id="lg-bag">
                    <a href="cart.php"><i class="far fa-shopping-bag"></i></a>
                </li>
                <a href="#" id="close"><i class="far fa-times"></i></a>
            </ul>
        </div>
    </section>

    <div class="container">
        <div class="titlecheck">
            <h2>Product Order Form</h2>
        </div>
        <div class="d-flex">
            <form method="post" id="form1">
                <input class="input11" type="text" name="houseadd" placeholder="Address" required>
                <input class="input11" type="text" name="city" placeholder="City" required>
                <input class="input11" type="text" name="country" placeholder="County/State" required>
                <input class="input11" id="account-field" type="text" name="acc" placeholder="Account Number">
                <div>
                    <input class="input2" type="radio" id="ac1" name="dbt" value="cod" onchange="showInputBox()"> Cash on Delivery
                </div>
                <div>
                    <input class="input2" type="radio" id="ac2" name="dbt" value="bank" checked onchange="showInputBox()"> Paypal/Visa/MasterCard
                </div>
                <button name="sub" type="submit" class="btn112">Place Order</button>
            </form>
        </div>
    </div>

    <script>
        function showInputBox() {
            var select = document.querySelector('#ac1');
            var inputBox = document.getElementById("account-field");
            inputBox.style.display = select.checked ? "none" : "block";
        }
    </script>
</body>

</html>
