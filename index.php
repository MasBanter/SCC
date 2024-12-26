<?php
session_start();

if (empty($_SESSION['aid']))
    $_SESSION['aid'] = -1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shop Component Computer</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
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

    <section id="hero">
        <h4>Halo! Selamat Datang</h4>
        <h2>Di Shop Component Computer</h2>
        <p>Menyediakan berbagai macam komponen komputer berkualitas tinggi untuk kebutuhan rakit PC, upgrade perangkat, serta perawatan komputer Anda. Kami menyediakan berbagai produk dari merek terpercaya, mulai dari prosesor, kartu grafis, motherboard. Selain itu, kami juga menawarkan berbagai aksesori komputer, pendingin sistem, dan peralatan lainnya yang dapat memenuhi kebutuhan gaming, desain grafis, serta komputasi berat.</p>
        <a href="shop.php">
            <button>Shop Now</button>
        </a>
    </section>

    <section id="feature" class="section-p1">
        <div class="fe-box">
            <img src="img/features/f1.png" alt="" />
            <h6>Pengiriman Gratis</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f2.png" alt="" />
            <h6>Online Order</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f6.png" alt="" />
            <h6>CS 24/7 </h6>
        </div>
    </section>


    <section id="sm-banner" class="section-p1">
        <div class="banner-box">
            <h4>crazy deals</h4>
            <h2>Beli kombo, dapatkan satu aksesori gratis</h2>
            <span>Klasik terbaik sedang dijual di SCC</span>
            <a href="shop.php">
                <button class="white">Learn More</button>
            </a>
        </div>
        <div class="banner-box banner-box2">
            <h4>Coming This Week</h4>
            <h2>Ragnar Sale</h2>
            <span>Klasik terbaik sedang dijual di SCC</span>
            <a href="shop.php">
                <button class="white">Collection</button>
            </a>
        </div>
    </section>

    <footer class="section-p1">
        <div class="col">
            <img class="logo" src="img/logo.png" />
            <h4>Contact</h4>
            <p>
                <strong>Address: </strong> Jln. Palagan, Sleman, Yogyakarta

            </p>
            <p>
                <strong>Phone: </strong> +62 812 3456 7891
            </p>
            <p>
                <strong>Hours: </strong> Senin hingga Sabtu: pukul 09.00 hingga 17.00
            </p>
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

<script>
window.addEventListener("onunload", function() {
  // Call a PHP script to log out the user
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "logout.php", false);
  xhr.send();
});
</script>