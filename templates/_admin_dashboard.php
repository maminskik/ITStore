<?php
include_once './classes/User.php';
include_once './classes/Orders.php';
include_once './classes/Product.php';
include_once './helpers/session_helper.php';

$user = new User();
$orders = new Orders();
$products = new Product();


$totalUsers = $user->countUsers();
$totalOrders = $orders->countOrders();
$totalProducts = $products->countProducts();

?>

<section class="admin-dashboard">
    <div class="container-dashboard">
        <div class="row">
            <div class="col-lg-12">
                <h1>PANEL</h1>
            </div>
        </div>
        <div class="row mt-5">
            <div class="stats-box col-lg-4">
                <div class="stats-box-content">
                    <div class="stats-box-header">
                        <h4>Liczba klientów</h2>
                    </div>
                    <div class="stats-box-body">
                        <p><?php echo $totalUsers->total_users; ?></p>
                    </div>
                </div>
            </div>
            <div class="stats-box col-lg-4">
                <div class="stats-box-content">
                    <div class="stats-box-header">
                        <h4>Liczba zamówień</h2>
                    </div>
                    <div class="stats-box-body">
                        <p><?php echo $totalOrders->total_orders; ?></p>
                    </div>
                </div>
            </div>

            <div class="stats-box col-lg-4">
                <div class="stats-box-content">
                    <div class="stats-box-header">
                        <h4>Liczba produktów</h2>
                    </div>
                    <div class="stats-box-body">
                        <p><?php echo $totalProducts->total_products; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>