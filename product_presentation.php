<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['adminId'])) {
    header('location:admin_panel.php');
}

?>

<?php
include_once 'header.php';
?>

<?php
include_once 'templates/_product_presentation.php';
?>

<?php
include_once 'footer.php';
?>