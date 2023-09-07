<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['adminId'])) {
    header('Location: admin_panel.php');
    exit();
}

if (!isset($_SESSION['userId'])) {
    header('location:index.php');
}

?>


<?php
include_once 'header.php';
?>

<?php
include_once 'templates/_cart.php'
?>

<?php
include_once 'footer.php';
?>