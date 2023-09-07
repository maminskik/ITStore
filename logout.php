<?php

if (!isset($_SESSION)) {
    session_start();
}

@include 'libs/Database.php';

if (isset($_SESSION['userEmail'])) {
    unset($_SESSION['userEmail']);
    unset($_SESSION['userId']);
}

if (isset($_SESSION['adminId'])) {
    unset($_SESSION['adminId']);
    unset($_SESSION['adminEmail']);
}


session_destroy();
header('location:index.php');