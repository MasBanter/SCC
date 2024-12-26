<?php
$con = mysqli_connect('localhost', 'root', '', 'computer_shop');
if (!$con) {
    echo "fail";
    die(mysqli_error($con));
}
?>