<?php

$conn = new mysqli('localhost', 'root', '', 'cumbre_pack');

if ($conn->connect_error) {
    die('Connection failed:' .$conn->connect_error);
}
?>
