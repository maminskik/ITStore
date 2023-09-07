<?php

include_once './classes/User.php';
include_once './helpers/session_helper.php';

$user = new User();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $_POST = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);

    $data = [
        'userName' => trim($_POST['userName']),
        'userSurname' => trim($_POST['userSurname']),
        'userEmail' => trim($_POST['userEmail']),
        'userPassword' => trim($_POST['userPassword'])
    ];

    $_SESSION['old'] = $data;


    if (empty($data['userName']) || empty($data['userSurname']) || empty($data['userEmail']) || empty($data['userPassword'])) {
        errorUser('register', 'Uzupełnij wszystkie pola');
        redirect("register.php");
    }

    if (!preg_match("/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ]*$/i", $data['userName'])) {
        errorUser("register", "Imię jest niepoprawne");
        redirect("register.php");
    }

    if (!filter_var($data['userEmail'], FILTER_VALIDATE_EMAIL)) {
        errorUser("register", "Wpisz poprawny adres email");
        redirect("register.php");
    }

    if (strlen($data['userPassword']) < 6) {
        errorUser("register", "Hasło musi mieć powyżej 6 znaków");
        redirect("register.php");
    }

    if ($user->findUserByEmail($data['userEmail'])) {
        errorUser("register", "Podany email jest zajęty");
        redirect("register.php");
    }

    $data['userPassword'] = password_hash($data['userPassword'], PASSWORD_DEFAULT);

    if ($user->registerUser($data)) {
        unset($_SESSION['old']);
        successUser("register", "Twoje konto zostało utworzone. Możesz się zalogować");
        redirect("login.php");
    } else {
        errorUser("register", "Coś poszło nie tak. Spróbuj ponownie");
        redirect("register.php");
    }
}

?>

<section class="register">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="register-box">
                    <div class="login-title mb-3">
                        <h3>Rejestracja</h3>
                    </div>
                    <div class="user-register">
                        <form method="post" action="" id="form" class="form">
                            <input type="hidden" name="type" value="register">
                            <div class="form-row label row">
                                <div class="col-lg-12 mt-3">
                                    <input type="name" name="userName" id="name" placeholder="Imię*" class="login-input"
                                        value="<?php echo isset($_SESSION['old']['userName']) ? htmlspecialchars($_SESSION['old']['userName']) : ''; ?>">
                                    <small class="form-error"></small>
                                </div>
                            </div>
                            <div class="form-row label row">
                                <div class="col-lg-12 mt-3">
                                    <input type="surname" name="userSurname" id="surname" placeholder="Nazwisko*"
                                        class="login-input"
                                        value="<?php echo isset($_SESSION['old']['userSurname']) ? htmlspecialchars($_SESSION['old']['userSurname']) : ''; ?>">
                                    <small class="form-error"></small>
                                </div>
                            </div>
                            <div class="form-row label row">
                                <div class="col-lg-12 mt-3">
                                    <input type="email" name="userEmail" id="email" placeholder="Email*"
                                        value="<?php echo isset($_SESSION['old']['userEmail']) ? htmlspecialchars($_SESSION['old']['userEmail']) : ''; ?>"
                                        class="login-input">
                                    <small class="form-error"></small>
                                </div>
                            </div>
                            <div class="form-row label row">
                                <div class="col-lg-12 mt-3">
                                    <input type="password" name="userPassword" id="password" placeholder="Hasło*"
                                        class="login-input">
                                    <small class="form-error"></small>
                                </div>
                            </div>
                    </div>
                    <div class="form-actions">
                        <div class="col-lg-12">
                            <button type="submit" class="button primary btn-login mt-5">Zarejestruj się</button>
                        </div>
                    </div>
                    <?php successUser('register') ?>
                    <?php errorUser('register') ?>

                </div>
            </div>
            <div class="col-lg-7">
                <div class="back-to-login">
                    <h3>Masz już konto?</h3>
                    <a href="login.php" class="button secondary mt-3"> Zaloguj się</a>
                </div>
            </div>
        </div>
    </div>
</section>