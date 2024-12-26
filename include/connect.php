<?php
$con = mysqli_init();
mysqli_ssl_set($con,NULL,NULL, NULL, NULL);
mysqli_real_connect($conn, "scc-server.mysql.database.azure.com", "nsruuvnlvc", "Putra.123.", "computerscc", 3306, MYSQLI_CLIENT_SSL);
if (!$con) {
    echo "fail";
    die(mysqli_error($con));
}
?>



