<?php

if (!isset($_SESSION)) {
	session_start();
}

$config_file = "./config/config.php";

if (!file_exists($config_file)) {
	header("Location: install.php");
}

if (isset($_SESSION['adminId'])) {
	header('Location: admin_panel.php');
	exit();
}

?>


<?php
include_once 'header.php';
?>

<?php
include_once 'templates/_product.php';
?>

<?php
include_once 'footer.php';
?>