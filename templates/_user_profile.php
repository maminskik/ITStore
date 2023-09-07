<?php

if (isset($_SESSION['adminId']) || !isset($_SESSION['userId'])) {
    header('location:admin_panel.php');
}


include_once './classes/User.php';
include_once './helpers/session_helper.php';

$user = new User();

$fetchUser = $user->findUseryById($_SESSION['userId']);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    switch ($_POST['type']) {
        case 'updatePass':

            $data = [
                'oldPassword' => trim($_POST['oldPassword']),
                'newPassword' => trim($_POST['newPassword']),
                'newPassword2' => trim($_POST['newPassword2'])
            ];

            if (empty($data['oldPassword']) || empty($data['newPassword']) || empty($data['newPassword2'])) {
                errorUser('updatePass', "Uzupełnij wszystkie pola!");
                redirect('user_profile.php');
            }

            if (!password_verify($data['oldPassword'], $fetchUser->Password)) {
                errorUser('updatePass', "Wpisz poprawne hasło");
                redirect('user_profile.php');
            }

            if (strlen($data['newPassword']) < 6) {
                errorUser("updatePass", "Hasło musi mieć powyżej 6 znaków");
                redirect("user_profile.php");
            }

            if ($data['newPassword'] != $data['newPassword2']) {
                errorUser("updatePass", "Hasła się nie zgadzają");
                redirect("user_profile.php");
            }

            $hashedPassword = password_hash($data['newPassword'], PASSWORD_DEFAULT);

            $user->updateUserPassword($_SESSION['userId'], $hashedPassword);

            if ($user->updateUserPassword($_SESSION['userId'], $hashedPassword)) {
                successUser("updatePass", "Twoje hasło zostało zakutalizowane :)");
                redirect("user_profile.php");
            } else {
                errorUser("updatePass", "Coś poszło nie tak. Spróbuj ponownie");
                redirect("user_profile.php");
            }
            break;
        case 'updateEmail':

            $data = [
                'email' => trim($_POST['userEmailUP']),
                'password' => trim($_POST['userEmailPass']),
            ];

            if (empty($data['email']) || empty($data['password'])) {
                errorUser('updateEmail', "Uzupełnij wszystkie pola!");
                redirect('user_profile.php');
            }

            if ($data['email'] == $fetchUser->Email) {
                errorUser('updateEmail', 'Wpisz nowy adres email');
                redirect('user_profile.php');
            }

            if ($user->findUserByEmail($data['email'])) {
                errorUser('updateEmail', 'Ten adres email jest zajęty');
                redirect('user_profile.php');
            }

            if (!password_verify($data['password'], $fetchUser->Password)) {
                errorUser('updateEmail', "Wpisz poprawne hasło");
                redirect('user_profile.php');
            }

            if ($user->updateUserEmail($_SESSION['userId'], $data['email'])) {
                successUser("updateEmail", "Twój email został zaktualizowany :)");
                redirect("user_profile.php");
            } else {
                errorUser("updateEmail", "Coś poszło nie tak. Spróbuj ponownie");
                redirect("user_profile.php");
            }
            break;
        case 'updateName':

            $data = [
                'name' => trim($_POST['userNameUP']),
                'surname' => trim($_POST['userSurnameUP']),
                'passwordSurname' => trim($_POST['userSurnamePass'])
            ];

            if (empty($data['name']) || empty($data['surname']) || empty($data['passwordSurname'])) {
                errorUser('updateName', "Uzupełnij wszystkie pola!");
                redirect('user_profile.php');
            }

            if ($data['name'] == $fetchUser->Name && $data['surname'] == $fetchUser->Surname) {
                errorUser('updateName', 'Wpisz nowe dane');
                redirect('user_profile.php');
            }

            if (!password_verify($data['passwordSurname'], $fetchUser->Password)) {
                errorUser('updateName', "Wpisz poprawne hasło");
                redirect('user_profile.php');
            }

            if ($user->updateUserName($_SESSION['userId'], $data['name'], $data['surname'])) {
                successUser("updateName", "Twoje imię i nazwisko zostało zaktualizowane :)");
                redirect("user_profile.php");
            } else {
                errorUser("updateName", "Coś poszło nie tak. Spróbuj ponownie");
                redirect("user_profile.php");
            }

            break;
        default:
            redirect("user_profile.php");
    }
}

?>

<section class="user-profile">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>PROFIL</h1>
            </div>
        </div>
        <div class="row profile-buttons">
            <div class="col-lg-12 col-py">
                <ul>
                    <li>
                        <button class="button primary btn-profile-update">Zmiana hasła</button>
                    </li>
                    <li>
                        <button class="button primary btn-profile-update">Zmiana email</button>
                    </li>
                    <li>
                        <button class="button primary btn-profile-update">Zmiana nazwiska</button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row row-update-profile" style="display:none">
            <div class="col-lg-5 mx-auto">
                <div class="profile-update-panel">
                    <h2 class="text-center mb-3">Zmiana hasła</h2>
                    <form method="post" class="form">
                        <input type="hidden" name="type" value="updatePass">
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <input type="password" name="oldPassword" placeholder="Wpisz stare hasło"
                                    class="login-input">
                            </div>
                        </div>
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <input type="password" name="newPassword" placeholder="Nowe hasło" class="login-input">
                            </div>
                        </div>
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <input type="password" name="newPassword2" placeholder="Powtórz nowe hasło"
                                    class="login-input">
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="col-lg-12">
                                <button type="submit" class="button primary btn-update mt-5">Zaktualizuj</button>
                            </div>
                            <?php errorUser('updatePass') ?>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="row row-update-profile" style="display:none">
            <div class="col-lg-5 mx-auto">
                <div class="profile-update-panel">
                    <h2 class="text-center mb-3">Zmiana email</h2>
                    <form method="post" class="form">
                        <input type="hidden" name="type" value="updateEmail">
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <input type="text" name="userEmailUP" placeholder="Email" class="login-input"
                                    value="<?= $fetchUser->Email; ?>">
                            </div>
                        </div>
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <input type="password" name="userEmailPass" placeholder="Wpisz hasło"
                                    class="login-input">
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="col-lg-12">
                                <button type="submit" class="button primary btn-update mt-5">Zaktualizuj</button>
                            </div>
                            <?php errorUser('updateEmail') ?>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="row row-update-profile" style="display:none">

            <div class="col-lg-5 mx-auto">
                <h2 class="text-center mb-3">Zmiana nazwiska</h2>
                <div class="profile-update-panel">
                    <form method="post" class="form">
                        <input type="hidden" name="type" value="updateName">
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <input type="text" name="userNameUP" placeholder="Imię" class="login-input"
                                    value="<?= $fetchUser->Name; ?>">
                            </div>
                        </div>
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <input type="text" name="userSurnameUP" placeholder="Nazwisko" class="login-input"
                                    value="<?= $fetchUser->Surname; ?>">
                            </div>
                        </div>
                        <div class="form-row label row">
                            <div class="col-lg-12 mt-3">
                                <input type="password" name="userSurnamePass" placeholder="Wpisz hasło"
                                    class="login-input">
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="col-lg-12">
                                <button type="submit" class="button primary btn-update mt-5">Zaktualizuj</button>
                            </div>
                            <?php errorUser('updateName') ?>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>