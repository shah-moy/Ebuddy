<?php
$connection=mysqli_connect ("localhost", 'root', '','ebuddy');
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}

?>