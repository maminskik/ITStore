<?php

include_once './classes/User.php';
include_once './helpers/session_helper.php';

$user = new User();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_POST['type'] == 'login') {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'userEmail' => trim($_POST['userEmail']),
            'userPassword' => trim($_POST['userPassword'])
        ];
        $_SESSION['old'] = $data;

        if (empty($data['userEmail']) || empty($data['userPassword'])) {
            errorUser('login', "Uzupełnij wszystkie pola!");
            redirect('login.php');
        }

        $existingUser = $user->findUserByEmail($data['userEmail']);

        if ($existingUser) {

            if ($existingUser->is_active == 0) {
                errorUser("login", "Użytkownik jest nieaktywny");
                redirect("login.php");
            }

            $loggedInUser = $user->login($data['userEmail'], $data['userPassword']);

            if ($loggedInUser) {
                if ($loggedInUser->RoleId == 1) {
                    unset($_SESSION['old']);
                    $user->createAdminSession($loggedInUser);
                } else {
                    unset($_SESSION['old']);
                    $user->createUserSession($loggedInUser);
                }
            } else {
                errorUser("login", "Niepoprawne hasło");
                redirect("login.php");
            }
        } else {
            errorUser("login", "Użytkownik nie istnieje");
            redirect("login.php");
        }
    }
}


?>

<section class="login">
    <div class="container">
        <div class="row">
            <?php successUser('register') ?>
            <div class="col-lg-5">
                <div class="login-box">
                    <div class="login-title mb-3">
                        <h3>Zaloguj się</h3>
                    </div>
                    <div class="user-login">
                        <form method="post" id="formLogin" class="form">
                            <input type="hidden" name="type" value="login">
                            <div class="form-row label row">
                                <div class="col-lg-12 mt-3">
                                    <input type="email" name="userEmail" id="email" placeholder="Email*"
                                        value="<?php echo isset($_SESSION['old']['userEmail']) ? htmlspecialchars($_SESSION['old']['userEmail']) : ''; ?>"
                                        class="login-input">

                                </div>
                            </div>
                            <div class="form-row label row">
                                <div class="col-lg-12 mt-3">
                                    <input type="password" name="userPassword" id="password" placeholder="Hasło"
                                        class="login-input">
                                    <small class="form-error"></small>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="col-lg-12">
                                    <button type="submit" class="button primary btn-login mt-5">Zaloguj</button>
                                </div>
                            </div>
                        </form>
                        <?php errorUser('login') ?>

                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="create-account">
                    <h3>Nie masz konta?</h3>
                    <a href="register.php" class="button secondary mt-3"> Załóż konto</a>
                </div>
            </div>
        </div>
    </div>
</section>