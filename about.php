<?php
session_start();
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
    .paragraph {
        line-height: 1.5;
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
                <li><a class="active" href="about.php">About</a></li>
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

    <section id="page-header" class="about-header">
        <h2>#GameTillTheEnd</h2>

        <p>Menyediakan Periferal Gaming Premium</p>
    </section>

    <section id="about-head" class="section-p1">
        <img src="img/about/x2.jpg" alt="" />
        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                        <h1 class="mb-4 text-center">Tentang Kami</h1>
                        <p class="mb-4 text-center">Selamat datang di Toko Shop Component Computer Kelompok 5, tempat terbaik untuk memenuhi
                        kebutuhan komponen komputer Anda. Kami adalah tim yang berkomitmen untuk menyediakan berbagai produk komputer berkualitas tinggi, 
                        mulai dari motherboard, CPU, RAM, kartu grafis, hingga perangkat keras lainnya yang diperlukan untuk merakit atau memperbaiki sistem komputer Anda.
                        </p>
                        <h1 class="mb-4 text-center">Visi</h1>
                        <p class="mb-4 text-center">Menjadi pilihan utama bagi para pelanggan yang mencari komponen komputer dengan kualitas terbaik, harga yang kompetitif, dan pelayanan yang memuaskan.</p>
                        <h1 class="mb-4 text-center">Misi</h1>
                        <div class="text-left">
                            <p><i class="fa fa-check text-primary me-3"></i>Menyediakan berbagai macam komponen komputer terbaru dan terpercaya untuk memenuhi kebutuhan teknologi Anda.</p>
                            <p><i class="fa fa-check text-primary me-3"></i>Memberikan pelayanan yang cepat dan ramah, serta konsultasi teknis bagi pelanggan yang membutuhkan bantuan dalam memilih produk yang sesuai.</p>
                            <p><i class="fa fa-check text-primary me-3"></i>Menjamin kualitas produk dengan menyediakan komponen-komponen dari merek ternama yang terjamin kehandalannya.</p>
                        </div>
                    </div>
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
window.addEventListener("unload", function() {
  // Call a PHP script to log out the user
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "logout.php", false);
  xhr.send();
});
</script>