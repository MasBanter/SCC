<?php
$con = mysqli_connect('scc-server.mysql.database.azure.com', 'nsruuvnlvc', 'Putra.123.', 'computer_shop');
if (!$con) {
    echo "fail";
    die(mysqli_error($con));
}
?>
