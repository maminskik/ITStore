<?php

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['adminId'])) {
    header('Location: admin_panel.php');
    exit();
} else if (isset($_SESSION['userId'])) {
    header('Location: index.php');
    exit();
}

?>

<?php
include_once 'header.php';
?>

<?php
include_once 'templates/_register.php';
?>

<?php
include_once 'footer.php';
?>