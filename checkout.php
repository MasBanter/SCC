<?php
session_start();

if (isset($_POST['sub'])) {
    include("include/connect.php");

    if (!isset($_SESSION['aid']) || !is_int($_SESSION['aid'])) {
        // Redirect or show error if session is invalid
        header("Location: login.php");
        exit();
    }

    $aid = $_SESSION['aid'];
    $add = mysqli_real_escape_string($con, $_POST['houseadd']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $acc = isset($_POST['acc']) ? mysqli_real_escape_string($con, $_POST['acc']) : null;

    $query = "";

    // Validate account number
    if (empty($acc)) {
        $query = "INSERT INTO `orders` (dateod, datedel, aid, address, city, country, account, total) 
                  VALUES (CURDATE(), NULL, '$aid', '$add', '$city', '$country', NULL, 0)";
    } else {
        if (preg_match('/\D/', $acc) || strlen($acc) != 16) {
            echo "<script> 
                    alert('Invalid account number'); 
                    setTimeout(function(){ window.location.href = 'checkout.php'; }, 100); 
                  </script>";
            exit();
        }

        $query = "INSERT INTO `orders` (dateod, datedel, aid, address, city, country, account, total) 
                  VALUES (CURDATE(), NULL, '$aid', '$add', '$city', '$country', '$acc', 0)";
    }

    if (!mysqli_query($con, $query)) {
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

    $tott = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $pid = $row['pid'];
        $cqty = $row['cqty'];
        $price = $row['price'];

        $query = "INSERT INTO `order-details` (oid, pid, qty) VALUES ($oid, $pid, $cqty)";
        if (!mysqli_query($con, $query)) {
            echo "Error executing query: " . mysqli_error($con);
            exit();
        }

        $query = "UPDATE products SET qtyavail = qtyavail - $cqty WHERE pid = $pid";
        if (!mysqli_query($con, $query)) {
            echo "Error executing query: " . mysqli_error($con);
            exit();
        }

        $tott += $price * $cqty;
    }

    $query = "DELETE FROM cart WHERE aid = $aid";
    if (!mysqli_query($con, $query)) {
        echo "Error executing query: " . mysqli_error($con);
        exit();
    }

    $query = "UPDATE orders SET total = $tott WHERE oid = $oid";
    if (!mysqli_query($con, $query)) {
        echo "Error executing query: " . mysqli_error($con);
        exit();
    }

    // Redirect to profile.php after processing
    header("Location: profile.php");
    exit();
}
?>
