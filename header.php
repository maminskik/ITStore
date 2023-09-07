<?php
if (!isset($_SESSION)) {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);

?>
<!doctype html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="ITStore">
    <title>ITStore</title>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header-content">
                        <div class="logo">
                            <div
                                style="position: absolute; left: 0; right: 0; bottom: 0; height: 1px; background-color: rgba(112, 128, 144, 0.2);">
                            </div>
                            <?php if ($current_page == 'install.php') : ?>
                            <a href="install.php?step=1"><img src="assets/img/logo/logo.png" class="img-fluid"
                                    width="99px"></a>
                            <?php else : ?>
                            <a href="index.php"><img src="assets/img/logo/logo.png" class="img-fluid" width="99px"></a>
                            <?php endif; ?>
                        </div>
                        <?php if ($current_page != 'install.php') : ?>
                        <div class="header-actions">
                            <?php if (isset($_SESSION['userEmail'])) { ?>
                            <a href="user_profile.php">
                                <ion-icon name="person-sharp" class="user-panel-icon"></ion-icon>
                            </a>
                            <a href="cart.php">
                                <ion-icon name="basket-sharp" class="user-panel-icon"></ion-icon>
                            </a>
                            <a href="logout.php">
                                <ion-icon name="log-out-sharp" class="user-panel-icon"></ion-icon>
                            </a>

                            <?php } else { ?>

                            <a href="login.php" class="button primary btn-login">Zaloguj się</a>
                            <?php } ?>
                        </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </header>
    </main>