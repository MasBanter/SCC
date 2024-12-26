<?php
// Menghubungkan ke database MySQL di Azure tanpa SSL
$con = mysqli_connect("scc-server.mysql.database.azure.com", "nsruuvnlvc", "Putra.123.", "computerscc", 3306);

// Mengecek apakah koneksi berhasil
if (!$con) {
    echo "Koneksi gagal: " . mysqli_connect_error();
    die();
}

// Jika berhasil, lanjutkan ke operasi lainnya
?>
