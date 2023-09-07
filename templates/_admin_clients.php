<?php

include_once './classes/User.php';
include_once './helpers/session_helper.php';

$user = new User();

if (isset($_GET['delete_user'])) {
    $userId = $_GET['delete_user'];
    $user->deleteUser($userId);
    redirect('admin_clients.php');
}

$currentUserId = $_SESSION['adminId'];
$allUsers = $user->getAllUsers($currentUserId);

?>

<section class="admin-dashboard">
    <div class="container-dashboard">
        <div class="row">
            <div class="col-lg-12">
                <h1>KLIENCI</h1>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Imię</th>
                            <th>Nazwisko</th>
                            <th>Email</th>
                            <th>Rola</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allUsers as $user) { ?>
                        <tr>
                            <td><?= $user->Name; ?></td>
                            <td><?= $user->Surname; ?></td>
                            <td><?= $user->Email; ?></td>
                            <td><?php if ($user->RoleId == 1) : ?>
                                Admin
                                <?php else : ?>
                                Użytkownik
                                <?php endif; ?></td>
                            <td>
                                <a href="admin_edit_client.php?edit_user_id=<?= $user->UserId; ?>">
                                    <ion-icon name="create-sharp" class="admin-panel-icon" style="color:black">
                                    </ion-icon>
                                </a>
                                <a href="?delete_user=<?= $user->UserId; ?>"
                                    onclick="return confirm('Czy na pewno chcesz usunąć tego klienta?')">
                                    <ion-icon name="trash-sharp" class="admin-panel-icon" style="color:black">
                                    </ion-icon>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>