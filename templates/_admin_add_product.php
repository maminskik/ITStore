<?php
include_once './classes/Product.php';
include_once './classes/Category.php';
include_once './helpers/session_helper.php';

$product = new Product();
$category = new Category();

$allCategories = $category->getAllCategories();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


    switch ($_POST['type']) {
        case 'addProduct':

            $data = [
                'productName' => trim($_POST['apName']),
                'productPrice' => trim($_POST['apPrice']),
                'productDesc' => trim($_POST['apDesc']),
                'productCategory' => trim($_POST['apCategory'])
            ];

            $image = $_FILES['image']['name'];
            $image = filter_var($image, FILTER_SANITIZE_STRING);
            $image_size = $_FILES['image']['size'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_folder = 'assets/img/' . $image;

            if (empty($data['productName']) || empty($data['productPrice']) || empty($data['productDesc'])) {
                errorUser('addProduct', "Uzupełnij wszystkie pola!");
                redirect('admin_add_product.php');
            }

            if (strlen($data['productName']) < 2) {
                errorUser("addProduct", "Podaj nazwę produktu");
                redirect('admin_add_product.php');
            }

            if ($image_size > 2000000) {
                errorUser("addProduct", "Zbyt duży rozmiar zdjęcia");
                redirect('admin_add_product.php');
            }

            if ($product->addProduct($data['productName'], $image, $data['productPrice'], $data['productDesc'], $data['productCategory'])) {
                move_uploaded_file($image_tmp_name, $image_folder);
                successUser("addProduct", "Produkt został dodany");
                redirect('admin_add_product.php');
            } else {
                errorUser("addProduct", "Coś poszło nie tak. Spróbuj ponownie");
                redirect("admin_add_product.php");
            }


            break;
    }
}

?>
<section class="admin-add-product">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>DODAJ PRODUKT</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 mx-auto">
                <div class="profile-update-panel">
                    <form method="post" class="form" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="addProduct">
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <input type="text" name="apName" placeholder="Nazwa produktu" class="login-input">
                            </div>
                        </div>
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <input type="number" name="apPrice" placeholder="Cena" class="login-input">
                            </div>
                        </div>
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <input type="text" name="apDesc" placeholder="Opis" class="login-input">
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

                                            echo "<option value=\"$categoryId\">$categoryName</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <input type="file" name="image" required class="box"
                                    accept="image/jpg, image/jpeg, image/png">
                            </div>

                        </div>
                        <div class="form-actions">
                            <div class="col-lg-12">
                                <button type="submit" class="button primary btn-update mt-5">Dodaj produkt</button>
                            </div>
                            <?php errorUser('addProduct'); ?>
                        </div>
                    </form>

                </div>
            </div>
        </div>
</section>