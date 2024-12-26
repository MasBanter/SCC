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

</head>

<body>
    <section id="header">
        <a href="index.php"><img src="img/logo.png" class="logo" alt="" /></a>

        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="about.php">About</a></li>
                <li><a class="active" href="contact.php">Contact</a></li>

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

        <p>Memberikan Pengalaman Gaming Premium</p>
    </section>

    <section id="contact-details" class="section-p1">
        <div class="details">
            <span>HUBUNGI</span>
            <h2>Kunjungi salah satu lokasi agensi kami atau hubungi kami hari ini</h2>
            <h3>Head Office</h3>
            <div>
                <li>
                    <i class="fal fa-map"></i>
                    <p>Jln. Palagan, Sleman, Yogyakarta</p>
                </li>
                <li>
                    <i class="fal fa-envelope"></i>
                    <p>scc@gmail.com</p>
                </li>
                <li>
                    <i class="fal fa-phone-alt"></i>
                    <p>+62 812 3456 7891</p>
                </li>
                <li>
                    <i class="fal fa-clock"></i>
                    <p>Senin hingga Sabtu: pukul 09.00 hingga 17.00</p>

                </li>
            </div>
        </div>
        <div class="map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3402.5655490104923!2d74.29819482695312!3d31.481135199999983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3919035b866b934b%3A0x8f191ce0dac7aa28!2sFast%20University!5e0!3m2!1sen!2s!4v1679911544138!5m2!1sen!2s"
                width="600" height="450" style="border: 0" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

    <section id="form-details">
        <div class="people">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">Team Kelompok 5</h1>
                    <p></p>
                </div>
            <div>
                <img src="img/people/a.jpg" alt="" />
                <p>
                    <span>Akbar Eka Putra Avrilian</span>22.83.0932<br />
                        <div class="position-center start-50 top-100 translate-middle d-flex align-items-center">
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-square mx-1" href="https://wa.me/6287776849729"><i class="fab fa-whatsapp"></i></a>
                            <a class="btn btn-square mx-1" href="https://www.instagram.com/panggilajakyy_?igsh=MWUzdXNhY2htaDRjeg=="><i class="fab fa-instagram"></i></a>
                        </div>
                </p>
            </div>
            <div>
                <img src="img/people/b.jpg" alt="" />
                <p>
                    <span>Rifky Dwi Prasetyo</span>22.83.0900<br />
                    <div class="position-center start-50 top-100 translate-middle d-flex align-items-center">
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-square mx-1" href="https://wa.me/6287776849729"><i class="fab fa-whatsapp"></i></a>
                            <a class="btn btn-square mx-1" href="https://www.instagram.com/panggilajakyy_?igsh=MWUzdXNhY2htaDRjeg=="><i class="fab fa-instagram"></i></a>
                    </div>
                </p>
            </div>
            <div>
                <img src="img/people/c.jpg" alt="" />
                <p>
                    <span>Andreas Saputra Sianipar</span>22.83.0911<br />
                    <div class="position-center start-50 top-100 translate-middle d-flex align-items-center">
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-square mx-1" href="https://wa.me/6287776849729"><i class="fab fa-whatsapp"></i></a>
                            <a class="btn btn-square mx-1" href="https://www.instagram.com/panggilajakyy_?igsh=MWUzdXNhY2htaDRjeg=="><i class="fab fa-instagram"></i></a>
                    </div>
                </p>
            </div>
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