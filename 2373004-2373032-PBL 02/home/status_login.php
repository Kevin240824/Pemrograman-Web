<?php
session_start();
$logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
?>