<?php
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "sinnamdb";
$link = mysqli_connect($db_host, $db_username, $db_password, $db_name);

if ($link->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}


if (!$link) {
    die(mysqli_error($link));
    // alternative way to display the error:
    // die(mysqli_connect_error());
}
?>
