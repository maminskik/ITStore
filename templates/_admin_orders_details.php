<?php
include_once './classes/Orders.php';
include_once './classes/Product.php';
include_once './helpers/session_helper.php';

$order = new Orders();
$product = new Product();

if (isset($_GET['order_id'])) {
    $orderId = $_GET['order_id'];
    $orderDetails = $order->getAllOrdersById($orderId);
}

?>

<section class="admin-edit-product">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>SZCZEGÓLY ZAMÓWIENIA</h1>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Produkt</th>
                            <th>Ilość</th>
                            <th>Cena jednostkowa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $index = 0;
                        $totalOrders = count($orderDetails);

                        while ($index < $totalOrders) {
                            $currentOrder = $orderDetails[$index];
                            $productId = $currentOrder->ProductId;
                            $products = $product->getProductById($productId);
                            if (!$products) {
                                $index++;
                                continue;
                            }
                        ?>
                        <tr>
                            <td><?php echo $products->Name; ?></td>
                            <td><?php echo $currentOrder->Amount; ?></td>
                            <td><?php echo $currentOrder->Unit_price; ?></td>
                        </tr>
                        <?php
                            $index++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>