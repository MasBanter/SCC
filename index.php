<?php
session_start();

if (empty($_SESSION['aid']))
    $_SESSION['aid'] = -1;

// Koneksi ke database
$conn = new mysqli("localhost", "username", "password", "nama_database");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil produk yang di-highlight
$sql = "SELECT id, nama_produk, gambar, harga FROM produk WHERE highlight = 1 LIMIT 3";
$result = $conn->query($sql);

$highlight_items = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $highlight_items[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shop Component Computer</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        #header {
            background-color: #333;
            color: white;
            padding: 20px;
        }

        #header .logo {
            width: 100px;
        }

        #navbar {
            list-style-type: none;
            display: flex;
            justify-content: flex-end;
            padding: 0;
        }

        #navbar li {
            margin: 0 15px;
        }

        #navbar li a {
            color: white;
            text-decoration: none;
        }

        #navbar li a:hover {
            text-decoration: underline;
        }

        #hero {
            background-color: #f4f4f4;
            padding: 50px 20px;
            text-align: center;
        }

        #highlight-products {
            padding: 40px 20px;
            text-align: center;
        }

        #highlight-products h2 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        .product-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .product-box {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            max-width: 250px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .product-box img {
            max-width: 100%;
            border-radius: 5px;
        }

        .product-box h3 {
            font-size: 1.2em;
            margin: 10px 0;
        }

        .product-box p {
            font-size: 1em;
            color: #555;
        }

        .product-box .btn {
            text-decoration: none;
            background-color: #ff5722;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }

        .product-box .btn:hover {
            background-color: #e64a19;
        }

        footer {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }

        footer a {
            color: white;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
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
    </section>

    <!-- Hero Section -->
    <section id="hero">
        <h4>Halo! Selamat Datang</h4>
        <h2>Di Shop Component Computer</h2>
        <p>Menyediakan berbagai macam komponen komputer berkualitas tinggi untuk kebutuhan rakit PC, upgrade perangkat, serta perawatan komputer Anda...</p>
        <a href="shop.php">
            <button>Shop Now</button>
        </a>
    </section>

    <!-- Highlight Products Section -->
    <section id="highlight-products" class="section-p1">
        <h2>Produk Unggulan</h2>
        <div class="product-container">
            <?php foreach ($highlight_items as $item): ?>
                <div class="product-box">
                    <img src="img/products/<?php echo $item['gambar']; ?>" alt="<?php echo $item['nama_produk']; ?>" />
                    <h3><?php echo $item['nama_produk']; ?></h3>
                    <p>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
                    <a href="detail.php?id=<?php echo $item['id']; ?>" class="btn">Lihat Detail</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="section-p1">
        <div class="col">
            <img class="logo" src="img/logo.png" />
            <h4>Contact</h4>
            <p><strong>Address: </strong> Jln. Palagan, Sleman, Yogyakarta</p>
            <p><strong>Phone: </strong> +62 812 3456 7891</p>
            <p><strong>Hours: </strong> Senin hingga Sabtu: pukul 09.00 hingga 17.00</p>
        </div>

        <div class="col">
            <h4>Akun Saya</h4>
            <a href="cart.php">Lihat Keranjang</a>
            <a href="wishlist.php">Daftar Keinginan Saya</a>
        </div>
        <div class="col install">
            <p>Pembayaran Aman</p>
            <img src="img/pay/pay.png" />
        </div>
        <div class="copyright">
            <p>2024. Kelompok 5 CC</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>

</html>
