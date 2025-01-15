<?php
// server, userdb, passdb, namedb
$connect = mysqli_connect("localhost", "root", "", "osa");

// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
