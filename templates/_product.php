<?php
include_once './classes/Category.php';
include_once './classes/Product.php';
include_once './classes/Cart.php';
include_once './helpers/session_helper.php';




$category = new Category();
$product = new Product();

$categories = $category->getAllCategories();
$allProducts = $product->getAllProducts();

if (isset($_GET['add_to_cart']) && isset($_GET['product_id'])) {

    if (!isset($_SESSION['userId'])) {
        redirect('login.php');
    }

    $productId = $_GET['product_id'];
    $cart = new Cart();
    $cart->addItem($productId);
    redirect('cart.php');
}

if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];
    redirect('product.php?id=' . $productId);
}
?>

<section class="store">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="store-title">
                    <h2>PRODUKTY</h2>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <aside class="col-md-3">
                <h3>Kategorie</h3>
                <ul class="category-list">
                    <li>
                        <?php
                        $isActiveAll = !isset($_GET['category']) || $_GET['category'] === '';
                        $activeClassAll = $isActiveAll ? 'active' : '';
                        ?>
                        <a href="?" class="<?= $activeClassAll ?>">Wszystkie</a>
                    </li>
                    <?php foreach ($categories as $category) : ?>
                    <?php
                        $categoryId = $category->CategoryId;
                        $isActive = isset($_GET['category']) && $_GET['category'] == $categoryId;
                        $activeClass = $isActive ? 'active' : '';
                        ?>
                    <li><a href="?category=<?= $categoryId ?>" class="<?= $activeClass ?>"><?= $category->Name ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </aside>
            <div class="col-md-9">
                <div class="product-list">
                    <ul class="product-list gallery">
                        <?php
                        if (isset($_GET['category'])) {
                            $products = $product->getProductByCategory($_GET['category']);

                            if (!empty($products)) {
                                foreach ($products as $p) {
                                    $productId = $p->ProductId;
                                    $productLink = 'product.php?id=' . $productId;
                        ?>
                        <li>
                            <a href="product_presentation.php?product_id=<?= $p->ProductId ?>" style="flex: 1 1;">
                                <div class="product-box">
                                    <div class="product-wrapper">
                                        <div class="product-graphic">
                                            <img class="img-fluid product-img" loading="lazy"
                                                src="assets/img/<?= $p->Image ?>" alt="">
                                        </div>
                                        <div class="product-title">
                                            <a href="<?= $productLink ?>">
                                                <span><?= $p->Name ?></span>
                                            </a>
                                        </div>
                                        <div class="product-price">
                                            <span><?= $p->Price ?></span>
                                            <a href="?add_to_cart=true&product_id=<?= $productId ?>">
                                                <ion-icon name="basket-sharp" class="basket-icon"
                                                    title="Dodaj do koszyka"></ion-icon>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php
                                }
                            } else {
                                echo '<li>Brak produktów w tej kategorii.</li>';
                            }
                        } else {
                            if (!empty($allProducts)) {
                                foreach ($allProducts as $p) {
                                    $productId = $p->ProductId;
                                    $productLink = 'product.php?id=' . $productId;
                                ?>
                        <li>
                            <a href="product_presentation.php?product_id=<?= $p->ProductId ?>" style="flex: 1 1;">
                                <div class="product-box">
                                    <div class="product-graphic">
                                        <img class="img-fluid product-img" loading="lazy"
                                            src="assets/img/<?= $p->Image ?>" alt="">
                                    </div>
                                    <div class="product-title">
                                        <a href="<?= $productLink ?>">
                                            <span><?= $p->Name ?></span>
                                        </a>
                                    </div>
                                    <div class="product-price">
                                        <span><?= $p->Price ?></span>
                                        <a href="?add_to_cart=true&product_id=<?= $productId ?>">
                                            <ion-icon name="basket-sharp" class="basket-icon" title="Dodaj do koszyka">
                                            </ion-icon>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php
                                }
                            } else {
                                echo '<li>Brak produktów.</li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>