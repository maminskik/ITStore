<?php
include_once './classes/Product.php';
include_once './helpers/session_helper.php';

$product = new Product();


if (isset($_GET['delete_product'])) {
    $productId = $_GET['delete_product'];
    $product->deleteProduct($productId);
    redirect('admin_products.php'); 
}

$products = $product->getAllProducts();
?>

<section class="admin-dashboard">
    <div class="container-dashboard">
        <div class="row">
            <div class="col-lg-12">
                <h1>PRODUKTY</h1>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nazwa</th>
                            <th>Cena</th>
                            <th>Opis</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product) { ?>
                            <tr>
                                <td><?= $product->Name; ?></td>
                                <td><?= $product->Price; ?></td>
                                <td><?= $product->Description; ?></td>
                                <td>
                                    <a href="admin_edit_product.php?edit_product_id=<?= $product->ProductId; ?>" class="mr-2"><ion-icon name="create-sharp" class="admin-panel-icon" style="color:black"></ion-icon></a>
                                    <a href="?delete_product=<?= $product->ProductId; ?>" onclick="return confirm('Czy na pewno chcesz usunąć ten produkt?')"><ion-icon name="trash-sharp"  class="admin-panel-icon" style="color:black"></ion-icon></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <a href="admin_add_product.php" class="button primary">Dodaj produkt</a>
            </div>
        </div>
    </div>
</section>