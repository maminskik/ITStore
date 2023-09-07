<?php
include_once './classes/Product.php';
include_once './classes/Category.php';
include_once './helpers/session_helper.php';

$product = new Product();
$category = new Category();

$allCategories = $category->getAllCategories();

if (isset($_GET['edit_product_id'])) {
    $productId = $_GET['edit_product_id'];
    $selectedProduct = $product->getProductById($productId);
}

if (!$selectedProduct) {
    echo 'Produkt nie istnieje.';
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


    switch ($_POST['type']) {
        case 'editProduct':

            $data = [
                'productName' => trim($_POST['apName']),
                'productPrice' => trim($_POST['apPrice']),
                'productDesc' => trim($_POST['apDesc']),
                'productCategory' => trim($_POST['apCategory'])
            ];


            if (empty($data['productName']) || empty($data['productPrice']) || empty($data['productDesc'])) {
                errorUser('editProduct', "Uzupełnij wszystkie pola!");
                redirect('admin_edit_product.php?edit_product_id=' . $productId);
            }

            if (strlen($data['productName']) < 2) {
                errorUser("editProduct", "Podaj nazwę produktu");
                redirect('admin_edit_product.php?edit_product_id=' . $productId);
            }


            if ($product->editProduct($data['productName'], $data['productPrice'], $data['productDesc'], $data['productCategory'], $selectedProduct->ProductId)) {
                successUser("editProduct", "Produkt został zaktualizowany");
                redirect('admin_edit_product.php?edit_product_id=' . $productId);
            } else {
                errorUser("editProduct", "Coś poszło nie tak. Spróbuj ponownie");
                redirect('admin_edit_product.php?edit_product_id=' . $productId);
            }
            break;
        case 'editProductImage':

            $image = $_FILES['image']['name'];
            $image = filter_var($image, FILTER_SANITIZE_STRING);
            $image_size = $_FILES['image']['size'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_folder = 'img/' . $image;

            if ($image_size > 2000000) {
                errorUser("editProductImage", "Zbyt duży rozmiar zdjęcia");
                redirect('admin_edit_product.php?edit_product_id=' . $productId);
            }

            if ($product->editProductImage($image, $selectedProduct->ProductId)) {
                move_uploaded_file($image_tmp_name, $image_folder);
                successUser("editProductImage", "Zdjęcie zostało zaktualizowane");
                redirect('admin_edit_product.php?edit_product_id=' . $productId);
            } else {
                errorUser("editProductImage", "Coś poszło nie tak. Spróbuj ponownie");
                redirect('admin_edit_product.php?edit_product_id=' . $productId);
            }

            break;
    }
}

?>

<section class="admin-edit-product">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>EDYTUJ PRODUKT</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 mx-auto">
                <div class="profile-update-panel">
                    <form method="post" class="form">
                        <input type="hidden" name="type" value="editProduct">
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <input type="text" name="apName" placeholder="Nazwa produktu" class="login-input"
                                    value="<?= $selectedProduct->Name; ?>">
                            </div>
                        </div>
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <input type="number" name="apPrice" placeholder="Cena" class="login-input"
                                    value="<?= $selectedProduct->Price; ?>">
                            </div>
                        </div>
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <select name="apCategory" class="login-input">
                                    <?php
                                    if (!empty($allCategories)) {
                                        foreach ($allCategories as $category) {
                                            $categoryId = $category->CategoryId;
                                            $categoryName = $category->Name;

                                            $selected = ($categoryId == $selectedProduct->CategoryId) ? 'selected' : '';

                                            echo "<option value=\"$categoryId\" $selected>$categoryName</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <textarea name="apDesc" placeholder="Opis" class="login-input"
                                    style="height:130px; padding-top: 10px;"><?= $selectedProduct->Description; ?></textarea>

                            </div>
                        </div>

                        <div class="form-actions">
                            <div class="col-lg-12">
                                <button type="submit" class="button primary btn-update mt-5">Edytuj produkt</button>
                            </div>
                            <?php errorUser('editProduct'); ?>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-12 text-center">
                <h1>EDYTUJ ZDJĘCIE</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 mx-auto">
                <div class="profile-update-panel">
                    <form method="post" class="form" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="editProductImage">
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <input type="file" name="image" required class="box"
                                    accept="image/jpg, image/jpeg, image/png">
                            </div>

                        </div>
                        <div class="form-actions">
                            <div class="col-lg-12">
                                <button type="submit" class="button primary btn-update mt-5">Edytuj zdjęcie</button>
                            </div>
                            <?php errorUser('editProductImage'); ?>
                        </div>
                    </form>

                </div>
            </div>
        </div>
</section>