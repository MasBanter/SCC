<?php
session_start();

if (isset($_POST['sub'])) {
    include("include/connect.php");

    $aid = $_SESSION['aid'];
    $add = $_POST['houseadd'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $acc = $_POST['acc'];
    $query = "";

    // Validasi nomor akun
    if (empty($acc)) {
        $query = "insert into `orders` (dateod, datedel, aid, address, city, country, account, total) values(CURDATE(), NULL, '$aid', '$add', '$city', '$country', NULL, 0)";
    } else {
        if (preg_match('/\D/', $acc) || strlen($acc) != 16) {
            echo "<script> alert('invalid account number'); setTimeout(function(){ window.location.href = 'checkout.php'; }, 100); </script>";
            exit();
        }

        $query = "insert into `orders` (dateod, datedel, aid, address, city, country, account, total) values(CURDATE(), NULL, '$aid', '$add', '$city', '$country', '$acc', 0)";
    }

    $result = mysqli_query($con, $query);
    if (!$result) {
        echo "Error executing query: " . mysqli_error($con);
        exit();
    }

    $oid = mysqli_insert_id($con);

    $query = "SELECT * FROM cart JOIN products ON cart.pid = products.pid WHERE aid = $aid";
    $result = mysqli_query($con, $query);
    if (!$result) {
        echo "Error executing query: " . mysqli_error($con);
        exit();
    }

    global $tott;
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
        $tott = $price * $cqty;

        $query = "insert into `order-details` (oid, pid, qty) values ($oid, $pid, $cqty)";
        $result2 = mysqli_query($con, $query);
        if (!$result2) {
            echo "Error executing query: " . mysqli_error($con);
            exit();
        }

        $query = "update products set qtyavail = qtyavail - $cqty where pid = $pid";
        $result2 = mysqli_query($con, $query);
        if (!$result2) {
            echo "Error executing query: " . mysqli_error($con);
            exit();
        }
    }

    $query = "delete from cart where aid = $aid";
    $result2 = mysqli_query($con, $query);
    if (!$result2) {
        echo "Error executing query: " . mysqli_error($con);
        exit();
    }

    $query = "update orders set total = $tott where oid = $oid";
    $result2 = mysqli_query($con, $query);
    if (!$result2) {
        echo "Error executing query: " . mysqli_error($con);
        exit();
    }

    // Redirect ke profile.php setelah proses selesai
    header("Location: profile.php");
    exit();
}
?>
