<?php
session_start();

if (empty($_SESSION['aid'])) {
    $_SESSION['aid'] = -1;
}

// Koneksi ke database
$conn = new mysqli("scc-server.mysql.database.azure.com", "nsruuvnlvc", "Putra.123.", "computerscc");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil produk yang di-highlight
$sql = "SELECT id, nama_produk, gambar, harga FROM produk WHERE highlight = 1 LIMIT 3";
$result = $conn->query($sql);

$highlight_items = [];
if ($result) { // Check if the query was successful
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $highlight_items[] = $row;
        }
    }
} else {
    echo "Error: " . $conn->error; // Display error if query fails
}

$conn->close(); // Close the database connection
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
        /* Your CSS styles here */
    </style>
</head>

<body>
    <section id="header">
        <a href="index.php"><img src="img/logo.png" class="logo" alt="Shop Component Computer Logo" /></a>
        <div>
            <ul id="navbar">
                <li><a class="active" href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>

                <?php
                if ($_SESSION['aid'] < 0) {
                    echo "<li><a href='login.php'>Login</a></li>
                          <li><a href='signup.php'>Sign Up</a></li>";
                } else {
                    echo "<li><a href='profile.php'>Profile</a></li>";
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
                    <img src="img/products/<?php echo htmlspecialchars($item['gambar']); ?>" alt="<?php echo htmlspecialchars($item['nama_produk']); ?>" />
                    <h3><?php echo htmlspecialchars($item['nama_produk']); ?></h3>
                    <p>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
                    <a href="detail.php?id=<?php echo htmlspecialchars($item['id']); ?>" class="btn">Lihat Detail</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="section-p1">
        <div class="col">
            <img class="logo" src="img/logo.png" alt="Shop Component Computer Logo" />
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
            <img src="img/pay/pay.png" alt="Payment Methods" />
        </div>
        <div class="copyright">
            <p>2024. Kelompok 5 CC</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>

</html>
