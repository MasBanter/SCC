<?php
session_start();

// Include the database connection file
include('connect.php');

// Fetch 5 highlighted products
function getHighlightedProducts() {
    global $conn; // Use the connection from connect.php

    $sql = "SELECT * FROM products WHERE is_highlighted = 1 LIMIT 5";
    $result = $conn->query($sql);

    $products = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    return $products;
}

// Call the function to fetch the highlighted products
$highlightedProducts = getHighlightedProducts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shop Component Computer</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <section id="header">
        <a href="index.php"><img src="img/logo.png" class="logo" alt="" /></a>
        <div>
            <ul id="navbar">
                <li><a class="active" href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>

                <?php
                if ($_SESSION['aid'] < 0) {
                    echo "<li><a href='login.php'>login</a></li><li><a href='signup.php'>SignUp</a></li>";
                } else {
                    echo "<li><a href='profile.php'>profile</a></li>";
                }
                ?>
                <li><a href="admin.php">Admin</a></li>
                <li id="lg-bag"><a href="cart.php"><i class="far fa-shopping-bag"></i></a></li>
            </ul>
        </div>
    </section>

    <section id="highlighted-products" class="section-p1">
        <h2>Featured Products</h2>
        <div class="product-container">
            <?php foreach ($highlightedProducts as $product): ?>
                <div class="product-box">
                    <img src="img/products/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" />
                    <h4><?php echo $product['name']; ?></h4>
                    <p><?php echo $product['description']; ?></p>
                    <span>Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></span>
                    <a href="product-detail.php?id=<?php echo $product['id']; ?>">View Details</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <footer class="section-p1">
        <div class="col">
            <img class="logo" src="img/logo.png" />
            <h4>Contact</h4>
            <p><strong>Address: </strong> Jln. Palagan, Sleman, Yogyakarta</p>
            <p><strong>Phone: </strong> +62 812 3456 7891</p>
        </div>
        <div class="col">
            <h4>Akun Saya</h4>
            <a href="cart.php">Lihat Keranjang</a>
            <a href="wishlist.php">Daftar Keinginan Saya</a>
        </div>
        <div class="copyright">
            <p>2024. Kelompok 5 CC</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>

</html>
