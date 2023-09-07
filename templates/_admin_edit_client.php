<?php
include_once './classes/User.php';
include_once './classes/Category.php';
include_once './helpers/session_helper.php';

$user = new User();
$category = new Category();

$allRoles = $user->getAllRoles();

if (isset($_GET['edit_user_id'])) {
    $userId = $_GET['edit_user_id'];
    $selectedUser = $user->findUseryById($userId);
}

if (!$selectedUser) {
    echo 'Klient nie istnieje.';
    exit;
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


    switch ($_POST['type']) {
        case 'editClient':

            $data = [
                'ekName' => trim($_POST['ekName']),
                'ekSurname' => trim($_POST['ekSurname']),
                'ekEmail' => trim($_POST['ekEmail']),
                'ekActive' => trim($_POST['ekActive']),
                'ekRole' => trim($_POST['ekRole']),
            ];

            if (empty($data['ekName']) || empty($data['ekSurname']) || empty($data['ekEmail'])) {
                errorUser('editUser', "Uzupełnij wszystkie pola!");
                redirect('admin_edit_client.php?edit_user_id=' . $userId);
            }

            if (strlen($data['ekName']) < 2) {
                errorUser("editUser", "Podaj imię użytkownika");
                redirect('admin_edit_client.php?edit_user_id=' . $userId);
            }

            if ($user->editUser($data['ekName'], $data['ekSurname'], $data['ekEmail'], $data['ekActive'], $data['ekRole'], $selectedUser->UserId)) {
                successUser("editUser", "Klient został zaktualizowany");
                redirect('admin_edit_client.php?edit_user_id=' . $userId);
            } else {
                errorUser("editUser", "Coś poszło nie tak. Spróbuj ponownie");
                redirect('admin_edit_client.php?edit_user_id=' . $userId);
            }
            break;
    }
}

?>


<section class="admin-edit-product">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>EDYTUJ KLIENTA</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 mx-auto">
                <div class="profile-update-panel">
                    <form method="post" class="form">
                        <input type="hidden" name="type" value="editClient">
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <input type="text" name="ekName" placeholder="Imię" class="login-input" value="<?= $selectedUser->Name; ?>">
                            </div>
                        </div>
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <input type="text" name="ekSurname" placeholder="Nazwisko" class="login-input" value="<?= $selectedUser->Surname; ?>">
                            </div>
                        </div>
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <input type="email" name="ekEmail" placeholder="Email" class="login-input" value="<?= $selectedUser->Email; ?>">
                            </div>
                        </div>
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <select name="ekRole" class="login-input">
                                    <?php
                                    if (!empty($allRoles)) {
                                        foreach ($allRoles as $role) {
                                            $roleId = $role->RoleId;
                                            $roleName = $role->Role;

                                            $selected = ($roleId == $selectedUser->RoleId) ? 'selected' : '';

                                            echo "<option value=\"$roleId\" $selected>$roleName</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <select name="ekActive" class="login-input">
                                    <option value="1" <?= $selectedUser->is_active == 1 ? 'selected' : '' ?>>Aktywny</option>
                                    <option value="0" <?= $selectedUser->is_active == 0 ? 'selected' : '' ?>>Nieaktywny</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="col-lg-12">
                                <button type="submit" class="button primary btn-update mt-5">Edytuj klienta</button>
                            </div>
                            <?php errorUser('editUser'); ?>
                        </div>
                    </form>

                </div>
            </div>
        </div>
</section>