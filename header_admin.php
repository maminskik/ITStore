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
    <div class="container-fluid">
        <aside>
            <nav class="admin-navigation">
                <div class="logo-admin">
                    <a href="index.php"><img src="assets/img/logo/logo-white.png" class="img-fluid" width="99px"></a>
                </div>
                <div class="admin-menu">
                    <ul class="admin-main-menu">
                        <a href="admin_panel.php" class="menu-link">
                            <li class=" menu-admin">
                                <ion-icon name="home-sharp" class="admin-panel-icon"></ion-icon>
                                </ion-icon><span class="link-text">Panel</span>
                            </li>
                        </a>
                        <a href="admin_clients.php" class="menu-link">
                            <li class="menu-admin">
                                <ion-icon name="person-sharp" class="admin-panel-icon"></ion-icon><span
                                    class="link-text">Klienci</span>
                            </li>
                        </a>
                        <a href="admin_orders.php" class="menu-link">
                            <li class="menu-admin">
                                <ion-icon name="pricetag-sharp" class="admin-panel-icon"></ion-icon><span
                                    class="link-text">Zamówienia</span>
                            </li>
                        </a>
                        <a href="admin_products.php" class="menu-link">
                            <li class="menu-admin">
                                <ion-icon name="cart-sharp" class="admin-panel-icon"></ion-icon><span
                                    class="link-text">Produkty</span>
                            </li>
                        </a>
                        <a href="admin_categories.php" class="menu-link">
                            <li class="menu-admin">
                                <ion-icon name="albums-sharp" class="admin-panel-icon"></ion-icon><span
                                    class="link-text">Kategorie</span>
                            </li>
                        </a>
                    </ul>
                    <ul class="admin-logout">
                        <a href="logout.php" class="menu-link">
                            <li class="menu-admin">
                                <ion-icon name="log-out-sharp" class="admin-panel-icon"></ion-icon><span
                                    class="link-text">Wyloguj
                            </li>
                        </a>
                    </ul>
                </div>

            </nav>
        </aside>

    </div>
    <main class="admin-main">