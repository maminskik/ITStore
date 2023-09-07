<?php
include_once './classes/Category.php';
include_once './helpers/session_helper.php';

$category = new Category();


$categories = $category->getAllCategories();
?>

<section class="admin-dashboard">
    <div class="container-dashboard">
        <div class="row">
            <div class="col-lg-12">
                <h1>KATEGORIE</h1>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nazwa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category) { ?>
                            <tr>
                                <td><?= $category->Name; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <a href="admin_add_category.php" class="button primary">Dodaj kategorie</a>
            </div>
        </div>
    </div>
</section>