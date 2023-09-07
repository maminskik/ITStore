<?php

include_once './classes/Cart.php';
include_once './helpers/session_helper.php';
include_once './classes/Product.php';
include_once './classes/Orders.php';


$cart = new Cart();
$product = new Product();
$order = new Orders();


if (isset($_GET['remove_from_cart']) && isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];
    $cart->removeItem($productId);
    redirect('cart.php');
}

if (isset($_POST['update'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $cart->updateItemQuantity($productId, $quantity);
    redirect('cart.php');
}

if (isset($_POST['order'])) {

    $cartItems = $cart->getItems();
    if (!empty($cartItems)) {

        $userId = $_SESSION['userId'];
        $orderData = array(
            'Date_Invoice' => date('Y-m-d H:i:s'),
            'Value' => $cart->getTotalPrice(),
            'UserId' => $userId
        );
        $orderId = $order->createOrder($orderData);


        foreach ($cartItems as $cartItem) {
            $productId = $cartItem['id'];
            $quantity = $cartItem['quantity'];
            $unitPrice = ($cartItem['price'] / $cartItem['quantity']);
            $order->createOrderDetail($orderId, $productId, $quantity, $unitPrice);
        }

        $cart->clearCart();
        redirect('thank_you.php');
    }
}

?>


<section class="basket">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="store-title">
                    <h2>KOSZYK</h2>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nazwa</th>
                            <th>Cena</th>
                            <th>Ilość</th>
                            <th>Usuń</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cartItems = $cart->getItems();
                        $totalPrice = 0;
                        if (!empty($cartItems)) {
                            foreach ($cartItems as $cartItem) {
                                $productId = $cartItem['id'];
                                $productPrice = $cartItem['price'];
                                $productQuantity = $cartItem['quantity'];
                                $subtotal = $productPrice;
                                $totalPrice += $subtotal;
                                $productName = $product->getProductById($productId)
                        ?>
                        <tr>
                            <td><?= $productName->Name; ?></td>
                            <td><?= $productPrice; ?></td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="product_id" value="<?= $productId; ?>">
                                    <input type="number" class="login-input" style="width:80px; height:30px;"
                                        name="quantity" value="<?= $productQuantity; ?>" min="1">
                                    <button type="submit" name="update" value="update"
                                        style="border:none; background:none;"><svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            style="width:19px;">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <a href="?remove_from_cart=true&product_id=<?= $productId; ?>">
                                    <ion-icon name="trash-sharp" class="admin-panel-icon" style="color:black">
                                </a>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                            ?>
                        <tr>
                            <td colspan="5">Koszyk jest pusty.</td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="row mt-4">
                    <div class="col-lg-12 text-lg-end text-center">
                        <h4>Całkowita suma: <?= $totalPrice; ?>PLN</h4>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12 text-lg-end text-center">
                        <form action="" method="post">
                            <button type="submit" name="order" class="button primary"
                                style="min-width:206px">Zamów</button>
                        </form>
                    </div>
                    <div class="col-lg-12 mt-2 text-lg-start text-center">
                        <a href="index.php" class="button secondary">Kontynuj zakupy</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>