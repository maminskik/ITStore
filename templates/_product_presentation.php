<?php
include_once './classes/Product.php';
include_once './classes/Cart.php';
include_once './helpers/session_helper.php';

$product = new Product();
$cart = new Cart();

if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];
    $selectedProduct = $product->getProductById($productId);
}

if (!$selectedProduct) {
    echo 'Produkt nie istnieje.';
    exit;
}


if (isset($_POST['add_to_cart'])) {


    if (!isset($_SESSION['userId'])) {
        redirect('login.php');
    }

    $quantity = $_POST['quantity'];
    $cart->addItem($selectedProduct->ProductId, $quantity);
    redirect('cart.php');
}

?>
<main>
    <section class="product-presentation" style="margin-top:50px">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php">Produkty</a>
                    </li>

                    <li class="breadcrumb-item active" aria-current="page">
                        <a
                            href="<?php echo 'product_presentation.php?product_id=' . htmlspecialchars($_GET['product_id']); ?>"><?= $selectedProduct->Name; ?></a>
                    </li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-lg-6 product-image-col d-flex mt-5">
                    <div class="product-image">
                        <img class="img-fluid" src="assets/img/<?= $selectedProduct->Image; ?>"
                            alt="<?= $selectedProduct->Name; ?>">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product-details">
                        <h1><?= $selectedProduct->Name; ?></h3>
                            <h3 class="mt-3">Cena: <?= $selectedProduct->Price; ?> PLN</h3>
                            <p class="mt-3"><?= $selectedProduct->Description; ?></p>
                            <form action="" method="post">
                                <input type="hidden" name="product_id" value="<?= $selectedProduct->ProductId; ?>">
                                <label for="quantity" class="mb-1">Ilość:</label>
                                <input style="width:200px" type="number" id="quantity" class="d-block login-input"
                                    name="quantity" value="1" min="1">
                                <button type="submit" name="add_to_cart" class="button primary btn-cart mt-4">Dodaj do
                                    koszyka</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>