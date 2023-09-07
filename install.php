<?php

include_once 'header.php';

$config_file = "config/config.php";
$sql_file = "config/sql.php";
$sql_insert_file = "config/sql_insert.php";

$step = isset($_GET['step']) ? (int) $_GET['step'] : 0;

switch ($step) {
    case 1:
        step1();
        break;
    case 2:
        step2($config_file);
        break;
    case 3:
        step3($config_file);
        break;
    case 4:
        step4($config_file);
        break;
    case 5:
        step5();
        break;
    default:
        defaultStep($config_file);
        break;
}

function defaultStep($config_file)
{
    if (file_exists($config_file)) {
        if (is_writable($config_file)) {
            header("Location: ?location=install&step=1");
        } else {
            echo "<div class='container mt-5'>";
            echo "<h1 class='mt-3 mb-3'>Instalator :: krok: 0</h1>";
            echo "<p>Zmień uprawnienia do pliku <code>./config/config.php</code><br>np. <code>chmod o+w ./config/config.php</code></p>";
            echo "<p><button class='btn button primary' onClick='window.location.href=window.location.href'>Odśwież stronę</button></p>";
            echo "</div>";
        }
    } else {
        echo "<div class='container mt-5'>";
        echo "<h1 class='mt-3 mb-3'>Instalator :: krok: 0</h1>";
        echo "<p>Stwórz plik <code>./config/config.php</code><br>np. <code> touch ./config/config.php</code></p>";
        echo "<p><button class='btn button primary' onClick='window.location.href=window.location.href'>Odśwież stronę</button></p>";
        echo "</div>";
    }
}

function describeTables($mysqli)
{
    $result = $mysqli->query("SHOW TABLES");
    if (!$result) {
        throw new Exception("Nie można pobrać listy tabel: " . $mysqli->error);
    }

    $tables = [];
    while ($row = $result->fetch_row()) {
        $tableName = $row[0];

        $columnsResult = $mysqli->query("DESCRIBE " . $tableName);
        if (!$columnsResult) {
            throw new Exception("Nie można pobrać kolumn dla tabeli $tableName: " . $mysqli->error);
        }

        $columns = [];
        while ($columnRow = $columnsResult->fetch_assoc()) {
            $columns[] = $columnRow;
        }

        $tables[$tableName] = $columns;
    }

    return $tables;
}


function step1()
{
    if (isset($_SESSION['error_message'])) {
        echo "
        <div class='container'>
            <div class='alert alert-danger'>" . $_SESSION['error_message'] . "</div>
        </div>
        ";
        unset($_SESSION['error_message']);
    }


    echo "<div class='container mt-5'>
        <h1 class='mt-3'>Instalator :: krok: 1</h1>
        <h3 class='mt-3 mb-3'>Instalacja serwisu</h3>
       <div class='row'>
        <div class='col-lg-6'>
            <form class='form-example text-center' action='' method='post'>
                <div class='row'>
                    <div class='col-lg-8 text-start'>
                    <label for='host' class='mb-1'>Nazwa lub adres serwera</label>
                    <input  type='text'
                            class='form-control username mb-1'
                            id='host'
                            name='host'/>
                    </div>
                    <div class='col-lg-8 text-start'>
                    <label for='dbname' class='mb-1'>Nazwa bazy danych</label>
                    <input type='text'
                            class='form-control username mb-1'
                            id='dbnama'
                            name='dbname'/>
                    </div>
                    <div class='col-lg-8 text-start'>
                    <label for='user' class='mb-1'>Nazwa użytkownika</label>
                    <input type='text'
                            class='form-control username mb-1'
                            id='user'
                            name='user'/>
                    </div>
                    <div class='col-lg-8 text-start'>
                    <label for='password' class='mb-1'>Hasło</label>
                    <input type='password'
                            class='form-control username mb-1'
                            id='password'
                            name='password'/>
                    </div>
                    <div class='row mt-3'>
                        <div class='col-lg-4'>
                            <button style='width:100%'class='button primary' onClick='window.location.href=window.location.href'>Prześlij dane</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
       </div>";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        writeConfigToFile();
    }
}

function writeConfigToFile()
{
    try {
        $config_content = sprintf(
            "<?php\n" .
                "define('DB_HOST', '%s');\n" .
                "define('DB_USER', '%s');\n" .
                "define('DB_PASS', '%s');\n" .
                "define('DB_NAME', '%s');\n",
            $_POST['host'],
            $_POST['user'],
            $_POST['password'],
            $_POST['dbname']
        );

        if (file_put_contents($GLOBALS['config_file'], $config_content) === false) {
            throw new Exception("Nie można zapisać do pliku");
        }


        $mysqli = new mysqli($_POST['host'], $_POST['user'], $_POST['password'], $_POST['dbname']);

        if ($mysqli->connect_error) {
            throw new Exception("Nie można połączyć się z bazą danych: " . $mysqli->connect_error);
        }

        header('Location: install.php?step=2');
    } catch (Exception $e) {
        $_SESSION['error_message'] = 'Wystąpił problem: ' . $e->getMessage();
        header('Location: install.php?step=1');
        exit;
    }
}

function step2($config_file)
{
    if (!file_exists($config_file)) {
        echo "Brak pliku konfiguracyjnego";
        exit;
    }
    require_once $config_file;

    echo "<div class='container mt-5'>";
    echo "<h1>Instalator :: krok: 2</h1>";
    echo "<h3 class='mt-3 mb-3'>Dodawanie tabel</h3>";

    try {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($mysqli->connect_error) {
            throw new Exception("Nie można połączyć się z bazą danych: " . $mysqli->connect_error);
        }

        include($GLOBALS['sql_file']);

        foreach ($create as $query) {
            if (!$mysqli->query($query)) {
                throw new Exception("Błąd podczas wykonywania zapytania: " . $query . " - " . $mysqli->error);
            }
        }


        echo "<a class='button primary mt-3 mb-3' href='?location=install&step=3'>Przejdź do kroku 3</a>";
        $tables = describeTables($mysqli);
        foreach ($tables as $tableName => $columns) {
            echo "<h4 class='mt-2 mb-2'>" . htmlspecialchars($tableName) . "</h4>";
            echo "<table class='table' border='1'>";
            echo "<tr><th>Nazwa kolumny</th><th>Typ</th><th>Klucz</th><th>Dodatkowo</th></tr>";
            foreach ($columns as $column) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($column['Field']) . "</td>";
                echo "<td>" . htmlspecialchars($column['Type']) . "</td>";
                echo "<td>" . htmlspecialchars($column['Key']) . "</td>";
                echo "<td>" . htmlspecialchars($column['Extra']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
        echo "<p><a class='btn btn-danger btn-customized' href='?location=install&step=1'>Wróć do poprzedniego kroku</a></p>";
    }

    echo "</div>";
}

function step3($config_file)
{
    if (!file_exists($config_file)) {
        echo "Brak pliku konfiguracyjnego";
        exit;
    }
    require_once $config_file;

    echo "<div class='container mt-5'>";
    echo "<h1 class='mt-3'>Instalator :: krok: 3</h1>";
    echo "<h3 class='mt-3 mb-3'>Zasilanie tabel danymi</h3>";
    echo "<a class='button primary mt-3 mb-3' href='?location=install&step=4'>Przejdź do kroku 4</a>";

    try {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($mysqli->connect_error) {
            throw new Exception("Nie można połączyć się z bazą danych: " . $mysqli->connect_error);
        }

        include($GLOBALS['sql_insert_file']);

        foreach ($insert as $query) {
            if (!$mysqli->query($query)) {
                throw new Exception("Błąd podczas wykonywania zapytania: " . $query . " - " . $mysqli->error);
            }
        }

        $tables = ['category', 'orders', 'orders_details', 'products', 'role', 'users'];

        foreach ($tables as $table) {
            $result = $mysqli->query("SELECT * FROM `$table`");
            if (!$result) {
                throw new Exception("Nie można pobrać danych z tabeli $table: " . $mysqli->error);
            }

            echo "<h4 class='mt-2 mb-2'> $table</h4>";
            echo "<table class='table' border='1'>";

            $columns = $result->fetch_fields();
            echo "<tr>";
            foreach ($columns as $column) {
                echo "<th>" . $column->name . "</th>";
            }
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($columns as $column) {
                    echo "<td>" . htmlspecialchars($row[$column->name]) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            $result->free();
        }
    } catch (Exception $e) {
        echo "<div class='container mt-3'>";
        echo "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
        echo "<p><a class='btn btn-danger btn-customized' href='?location=install&step=1'>Wróć do poprzedniego kroku</a></p>";
    }

    echo "</div>";
}


function step4($config_file)
{
    require_once $config_file;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        updateConfig($config_file);
        return;
    }

    echo "
    <div class='container mt-5'>
        <h1 class='mt-3'>Instalator :: krok: 4</h1>
        <h3 class='mt-3 mb-3'>Konfiguracja</h3>
        <div class='row'>
            <div class='col-lg-6'>
                <form class='form-example text-center' action='?step=4' method='post'>
                    <div class='row'>
                        <div class='col-lg-8 text-start'>
                            <label for='url' class='mb-1'>URL aplikacji:</label>
                            <input type='text' class='form-control username mb-1' id='url' name='url'/>
                        </div>
                        <div class='col-lg-8 text-start'>
                            <label for='app_name' class='mb-1'>Nazwa aplikacji:</label>
                            <input type='text' class='form-control username mb-1' id='app_name' name='app_name'/>
                        </div>
                        <div class='col-lg-8 text-start'>
                            <label for='origin_date' class='mb-1'>Data powstania:</label>
                            <input type='date' class='form-control username mb-1' id='origin_date' name='origin_date'/>
                        </div>
                        <div class='col-lg-8 text-start'>
                            <label for='version' class='mb-1'>Wersja:</label>
                            <input type='text' class='form-control username mb-1' id='version' name='version'/>
                        </div>
                        <div class='col-lg-8 text-start'>
                            <label for='admin_email' class='mb-1'>Email Administratora:</label>
                            <input required type='email' class='form-control username mb-1' id='admin_email' name='admin_email'/>
                        </div>
                        <div class='col-lg-8 text-start'>
                            <label for='admin_firstname' class='mb-1'>Imię Administratora:</label>
                            <input required type='text' class='form-control username mb-1' id='admin_firstname' name='admin_firstname'/>
                        </div>
                        <div class='col-lg-8 text-start'>
                            <label for='admin_lastname' class='mb-1'>Nazwisko Administratora:</label>
                            <input required type='text' class='form-control username mb-1' id='admin_lastname' name='admin_lastname'/>
                        </div>
                        <div class='col-lg-8 text-start'>
                            <label for='admin_password' class='mb-1'>Hasło Administratora:</label>
                            <input required type='password' class='form-control username mb-1' id='admin_password' name='admin_password'/>
                        </div>
                        <div class='row mt-3'>
                            <div class='col-lg-4'>
                                <input type='submit' class='button primary' value='Zapisz' style='width:100%'>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>";
}

function updateConfig($config_file)
{

    $additional_config = sprintf(
        "\n\$url = '%s';\n" .
            "\$app_name = '%s';\n" .
            "\$origin_date = '%s';\n" .
            "\$version = '%s';\n",
        $_POST['url'],
        $_POST['app_name'],
        $_POST['origin_date'],
        $_POST['version']
    );

    if (file_put_contents($config_file, $additional_config, FILE_APPEND) === false) {
        echo "Nie można zapisać do pliku";
        exit;
    }

    require_once $config_file;

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($mysqli->connect_error) {
        die("Nie można połączyć z bazą danych: " . $mysqli->connect_error);
    }

    $admin_email = $mysqli->real_escape_string($_POST['admin_email']);
    $admin_firstname = $mysqli->real_escape_string($_POST['admin_firstname']);
    $admin_lastname = $mysqli->real_escape_string($_POST['admin_lastname']);
    $admin_password = password_hash($_POST['admin_password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO Users (name, surname, email, password, is_active, RoleId) VALUES ('$admin_firstname', '$admin_lastname', '$admin_email', '$admin_password', 1, 1)";

    if ($mysqli->query($sql) === true) {
        echo "Konto administratora zostało utworzone";
        header('Location: install.php?step=5');
    } else {
        echo "Błąd przy tworzeniu konta administratora: " . $mysqli->error;
    }

    $mysqli->close();
}


function step5()
{
    echo "<div class='container mt-5'>
        <h1 class='mt-3'>Instalator :: krok: 5</h1>
        <h3 class='mt-3 mb-3'>Instalacja zakończona</h3>
        <a class='button primary' href='index.php'>Przejdź do strony</a>
    </div>";
}