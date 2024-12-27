<?php
session_start();
include("include/connect.php");

if (isset($_POST['submit'])) {
    $firstname = $_POST['firstName'];
    $lastname = $_POST['lastName'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmPassword'];
    $cnic = $_POST['cnic'];
    $dob = $_POST['dob'];
    $contact = $_POST['phone'];
    $gen = $_POST['gender'];
    $email = $_POST['email'];

    // Validasi input
    if (empty($firstname) || empty($lastname) || empty($username) || empty($password) || empty($confirmpassword) || empty($cnic) || empty($dob) || empty($contact) || $gen === "S" || empty($email)) {
        echo "All fields are required.";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    if ($password !== $confirmpassword) {
        echo "Passwords do not match.";
        exit();
    }

    // Hashing password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepared statement untuk mencegah SQL injection
    $query = "INSERT INTO accounts (afname, alname, phone, email, cnic, dob, username, gender, password) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);

    if (!$stmt) {
        die("SQL Error: " . mysqli_error($con));
    } else {
        mysqli_stmt_bind_param($stmt, "sssssssss", $firstname, $lastname, $contact, $email, $cnic, $dob, $username, $gen, $hashed_password);
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error executing query: " . mysqli_stmt_error($stmt);
        } else {
            echo "Account created successfully!";
        }
    }
    mysqli_stmt_close($stmt);
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
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <section id="header">
        <a href="#"><img src="img/logo.png" class="logo" alt="" /></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a class="active" href="signup.php">SignUp</a></li>
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

    <form method="post" action="signup.php" id="form">
        <h3 style="color: darkred; margin: auto"></h3>
        <input class="input1" id="fn" name="firstName" type="text" placeholder="First Name *" required>
        <input class="input1" id="ln" name="lastName" type="text" placeholder="Last Name *" required>
        <input class="input1" id="user" name="username" type="text" placeholder="Username *" required>
        <input class="input1" id="email" name="email" type="email" placeholder="Email *" required>
        <input class="input1" id="pass" name="password" type="password" placeholder="Password *" required>
        <input class="input1" id="cpass" name="confirmPassword" type="password" placeholder="Confirm Password *" required>
        <input class="input1" id="cnic" name="cnic" type="text" placeholder="CNIC *" required>
        <input class="input1" id="dob" name="dob" type="date" required>
        <input class="input1" id="contact" name="phone" type="text" placeholder="Contact *" required>
        <select class="select1" id="gen" name="gender" required>
            <option value="S">Select Gender</option>
            <option value="M">Male</option>
            <option value="F">Female</option>
        </select>
        <button name="submit" type="submit" class="btn">Submit</button>
    </form>

    <div class="sign">
        <a href="login.php" class="sign">Already have an account?</a>
    </div>

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

    <script>
        document.getElementById("form").addEventListener("submit", function (event) {
            const password = document.getElementById("pass").value;
            const confirmPassword = document.getElementById("cpass").value;
            if (password !== confirmPassword) {
                event.preventDefault();
                alert("Passwords do not match!");
            }
        });
    </script>
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
