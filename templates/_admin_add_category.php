<?php

include_once './classes/Category.php';
include_once './helpers/session_helper.php';

$category = new Category();

$allCategories = $category->getAllCategories();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    switch ($_POST['type']) {
        case 'addCategory':

            $data = [
                'categoryName' => trim($_POST['acCategory']),
            ];

            if (empty($data['categoryName'])) {
                errorUser('addCategory', "Uzupełnij wszystkie pola!");
                redirect('admin_add_category.php');
            }

            if (strlen($data['categoryName']) < 2) {
                errorUser("addCategory", "Podaj prawidłową nazwę kategorii");
                redirect('admin_add_category.php');
            }

            if ($category->checkCategoryExists($data['categoryName'])) {
                errorUser("addCategory", "Kategoria o podanej nazwie już istnieje");
                redirect('admin_add_category.php');
            }

            if ($category->addCategory($data['categoryName'])) {
                successUser("addCategory", "Kategoria została dodana");
                redirect('admin_add_category.php');
            } else {
                errorUser("addCategory", "Coś poszło nie tak. Spróbuj ponownie");
                redirect('admin_add_category.php');
            }

            break;
    }
}

?>

<section class="admin-add-product">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>DODAJ KATEGORIE</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 mx-auto">
                <div class="profile-update-panel">
                    <form method="post" class="form">
                        <input type="hidden" name="type" value="addCategory">
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <input type="text" name="acCategory" placeholder="Nazwa kategorii" class="login-input">
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="col-lg-12">
                                <button type="submit" class="button primary btn-update mt-5">Dodaj kategorie</button>
                            </div>
                            <?php errorUser('addCategory'); ?>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>