<?php
// Melakukan koneksi ke database tanpa SSL
$con = mysqli_connect("scc-server.mysql.database.azure.com", "nsruuvnlvc", "Putra.123.", "computerscc", 3306);

if (!$con) {
    echo "fail";
    die(mysqli_error($con));
}

// Jika koneksi berhasil
echo "Koneksi berhasil!";
?>
