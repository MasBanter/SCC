<?php
$con = mysqli_connect('scc-server.mysql.database.azure.com', 'nsruuvnlvc', 'Putra.123.', 'computerscc');
if (!$con) {
    echo "fail";
    die(mysqli_error($con));
}
?>
