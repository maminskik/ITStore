<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['adminId'])) {

    header('Location: index.php');
    exit();
}

?>

<?php
include_once 'header_admin.php';
?>
<?php
include_once 'templates/_admin_orders_details.php';
?>
<?php
include_once 'footer_admin.php';
?>