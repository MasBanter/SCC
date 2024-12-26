<?php
// Menghubungkan ke database MySQL di Azure tanpa SSL
$con = mysqli_connect('scc-server.mysql.database.azure.com', 'nsruuvnlvc', 'Putra.123.', 'computerscc');
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Jika berhasil, lanjutkan ke operasi lainnya
?>
