<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "accomio";

$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_SESSION["cd"])) {
    $sql_login = "SELECT * FROM customers WHERE code = '" . $_SESSION["cd"] . "' AND log = '" . $_SESSION["lg"] . "'";
    $s_login = $conn->query($sql_login);
    if ($s_login->num_rows == 0) {
        session_destroy();
    };
};

if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    if ($lang == "en" || $lang == "de" || $lang == "sk") {
        unset($_COOKIE['lang']);
        setcookie("lang", $lang, time() + (86400 * 30), "/");
    } else {
        $lang = "en";
        unset($_COOKIE['lang']);
        setcookie("lang", "en", time() + (86400 * 30), "/");
    };
} elseif (isset($_COOKIE['lang'])) {
    $lang = $_COOKIE['lang'];
} else {
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    if ($lang == "en" || $lang == "de" || $lang == "sk") {
        unset($_COOKIE['lang']);
        setcookie("lang", $lang, time() + (86400 * 30), "/");
    } else {
        $lang = "en";
        unset($_COOKIE['lang']);
        setcookie("lang", "en", time() + (86400 * 30), "/");
    };
};

function t($original) {
    global $lang;
    $sql_lang = "SELECT * FROM translations WHERE lang = '" . $lang . "' AND original = '" . $original . "'";
    global $conn;
    $s_lang = $conn->query($sql_lang);
    if ($s_lang->num_rows > 0) {
        $res_lang = $s_lang->fetch_assoc();
        return $res_lang['new'];
    } else {
        return $original;
    }
}

if (isset($_SESSION["cd"])) {
    header("Location: /accomio/user");
} elseif (isset($_POST["email"])) { // email
    $sql_email = "SELECT * FROM customers WHERE email = '" . $_POST["email"] . "'";
    $s_email = $conn->query($sql_email);
    if ($s_email->num_rows == 0) { // reg form
        echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
            var loginpage = document.querySelector("#login-page")
            if (loginpage) {
                loginpage.innerHTML = `<form id="login-page-form" method="post" action="login.php"><label for="emailx">' . t("Zadajte svoj email") . '</label><br><input type="email" id="emailx" name="emailx" class="loginfield" value="' . $_POST["email"] . '" readonly required><br><label for="name">' . t("Zadajte svoje meno") . '</label><br><input type="text" id="name" name="name" class="loginfield" required><br><label for="surname">' . t("Zadajte svoje priezvisko") . '</label><br><input type="text" id="surname" name="surname" class="loginfield" required><br><label for="callingcode">' . t("Zadajte svoje telefónne číslo") . '</label><br><select id="callingcode" name="callingcode" class="loginfield" style="margin: 2vh 0vw 2vh 1vw;width:5vw;" required><option value="" selected disabled></option><option value="+420">+420</option><option value="+421">+421</option>' /* */ . '</select><input type="number" id="telephone" name="telephone" class="loginfield" style="margin: 2vh 1vw 2vh 0vw;width:15vw;" maxlength="9" minlength="9" required><br><label for="address">' . t("Zadajte svoju adresu") . '</label><br><input type="text" id="address" name="address" class="loginfield" required><br><label for="city">' . t("Zadajte svoje mesto") . '</label><br><input type="text" id="city" name="city" class="loginfield" required><br><label for="country">' . t("Vyberte svoj štát") . '</label><br><select id="country" name="country" class="loginfield" required><option value="" selected disabled></option><option value="Czech republic">Česká republika</option><option value="Slovakia">Slovenská republika</option>' /* */ . '</select><br><label for="nationality">' . t("Vyberte svoju národnosť") . '</label><br><select id="nationality" name="nationality" class="loginfield" required><option value="" selected disabled></option><option value="Czech">Česká</option><option value="Slovak">Slovenská</option>' /* */ . '</select><br><label for="password">' . t("Zadajte svoje heslo") . '</label><br><input type="password" id="passwordx" name="passwordx" class="loginfield" required><br><input type="submit" value="' . t("Zaregistrovať sa") . '"></form>`
            }
            var welcometext = document.querySelector("#welcometext")
            if (welcometext) {
                welcometext.innerHTML = "' . t("Vytvorte si nový účet") . '"
            }
            }) </script>';
    } else { // log form
        echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
            var loginpage = document.querySelector("#login-page")
            if (loginpage) {
                loginpage.innerHTML = `<form id="login-page-form" method="post" action="login.php"><label for="emailx">' . t("Zadajte svoj email") . '</label><br><input type="email" id="emailx" name="emailx" class="loginfield" value="' . $_POST["email"] . '" readonly required><br><label for="password">' . t("Zadajte svoje heslo") . '</label><br><input type="password" id="password" name="password" class="loginfield" required><br><input type="submit" value="' . t("Prihlásiť sa") . '"></form>`
            }
            var welcometext = document.querySelector("#welcometext")
            if (welcometext) {
                welcometext.innerHTML = "' . t("Prihláste sa") . '"
            }
            }) </script>';
    }
} elseif (isset($_POST["password"])) { // log
    $sql_email = "SELECT * FROM customers WHERE email = '" . $_POST["emailx"] . "'";
    $s_email = $conn->query($sql_email);
    $result = $s_email->fetch_assoc();
    if (password_verify($_POST["password"], $result["password"])) { // correct
        $log = password_hash($_SERVER['REMOTE_ADDR'], PASSWORD_DEFAULT);
        $sql_log = "UPDATE customers SET log = '" . $log . "' WHERE email = '" . $_POST["emailx"] . "'";
        $conn->query($sql_log);
        if ($conn->affected_rows > 0) { // success
            $_SESSION["lg"] = $log;
            $_SESSION["cd"] = $result["code"];
            header("Location: /accomio");
        } else { // error
            echo "<script>
                document.addEventListener('DOMContentLoaded', () => {
                    var loginpage = document.querySelector('#login-page');
                    if (loginpage) {
                        loginpage.innerHTML = `<form id='login-page-form' method='post' action='login.php'><label for='emailx'>" . t("Zadajte svoj email") . "</label><br><input type='email' id='emailx' name='emailx' class='loginfield' value='" . $_POST["email"] . "' readonly required><br><label for='password'>" . t("Zadajte svoje heslo") . "</label><br><input type='password' id='password' name='password' class='loginfield' required><br><input type='submit' value='" . t("Prihlásiť sa") . "'></form>`;
                    }
                    var welcometext = document.querySelector('#welcometext');
                    if (welcometext) {
                        welcometext.innerHTML = `<div class='loginalert' style='background-color:red;'>" . t("Prihlásenie bolo neúspečné. Skúste to znova.") . "</div>" . t("Prihláste sa") . "`;
                </script>";
        };
    } else { // wrong
        echo "<script>
            document.addEventListener('DOMContentLoaded', () => {
                var loginpage = document.querySelector('#login-page');
                if (loginpage) {
                    loginpage.innerHTML = `<form id='login-page-form' method='post' action='login.php'><label for='emailx'>" . t("Zadajte svoj email") . "</label><br><input type='email' id='emailx' name='emailx' class='loginfield' value='" . $_POST["email"] . "' required><br><label for='password'>" . t("Zadajte svoje heslo") . "</label><br><input type='password' id='password' name='password' class='loginfield' required><br><input type='submit' value='" . t("Prihlásiť sa") . "'></form>`;
                }
                var welcometext = document.querySelector('#welcometext');
                if (welcometext) {
                    welcometext.innerHTML = `<div class='loginalert' style='background-color:red;'>" . t("Nesprávne heslo. Skúste to znova.") . "</div>" . t("Prihláste sa") . "`;
                }
            });
        </script>";
    };
} elseif (isset($_POST["passwordx"])) { // reg
    $sql_emailx = "SELECT * FROM customers WHERE email = '" . $_POST["emailx"] . "'";
    $s_emailx = $conn->query($sql_emailx);
    if ($s_emailx->num_rows > 0) { // already reg
        echo "<script>
            document.addEventListener('DOMContentLoaded', () => {
                var loginpage = document.querySelector('#login-page');
                if (loginpage) {
                    loginpage.innerHTML = `<form id='login-page-form' method='post' action='login.php'><label for='emailx'>" . t("Zadajte svoj email") . "</label><br><input type='email' id='emailx' name='emailx' class='loginfield' value='" . $_POST["emailx"] . "' required><br><label for='password'>" . t("Zadajte svoje heslo") . "</label><br><input type='password' id='password' name='password' class='loginfield' required><br><input type='submit' value='" . t("Prihlásiť sa") . "'></form>`;
                }
                var welcometext = document.querySelector('#welcometext');
                if (welcometext) {
                    welcometext.innerHTML = `<div class='loginalert' style='background-color:red;'>" . t("Email je už registroavný. Prosím prihláste sa.") . "</div>" . t("Prihláste sa") . "`;
                }
            });
        </script>";
    } else {
        $sql_reg = "INSERT INTO customers (name, surname, email, telephone, address, nationality, password, code) VALUES ('" . $_POST["name"] . "', '" . $_POST["surname"] . "', '" . $_POST["emailx"] . "', '" . $_POST["callingcode"] . $_POST["telephone"] . "', '" . $_POST["address"] . ", " . $_POST["city"] . ", " . $_POST["country"] . "', '" . $_POST["nationality"] . "', '" . password_hash($_POST["passwordx"], PASSWORD_DEFAULT) . "', '" . bin2hex(random_bytes(16)) . "')";
        $conn->query($sql_reg);
        if ($conn->affected_rows > 0) { // success
            echo "<script>
                document.addEventListener('DOMContentLoaded', () => {
                    var loginpage = document.querySelector('#login-page');
                    if (loginpage) {
                        loginpage.innerHTML = `<form id='login-page-form' method='post' action='login.php'><label for='emailx'>" . t("Zadajte svoj email") . "</label><br><input type='email' id='emailx' name='emailx' class='loginfield' value='" . $_POST["emailx"] . "' required><br><label for='password'>" . t("Zadajte svoje heslo") . "</label><br><input type='password' id='password' name='password' class='loginfield' required><br><input type='submit' value='" . t("Prihlásiť sa") . "'></form>`;
                    }
                    var welcometext = document.querySelector('#welcometext');
                    if (welcometext) {
                        welcometext.innerHTML = `<div class='loginalert' style='background-color:green;'>" . t("Úspešne ste sa zaregistrovali. Prosím prihláste sa.") . "</div>" . t("Prihláste sa") . "`;
                    }
                });
            </script>";
        } else { // error
            echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var loginpage = document.querySelector("#login-page");
                if (loginpage) {
                loginpage.innerHTML = `<form id="login-page-form" method="post" action="login.php"><label for="emailx">' . t("Zadajte svoj email") . '</label><br><input type="email" id="emailx" name="emailx" class="loginfield" value="' . $_POST["email"] . '" readonly required><br><label for="name">' . t("Zadajte svoje meno") . '</label><br><input type="text" id="name" name="name" class="loginfield" required><br><label for="surname">' . t("Zadajte svoje priezvisko") . '</label><br><input type="text" id="surname" name="surname" class="loginfield" required><br><label for="callingcode">' . t("Zadajte svoje telefónne číslo") . '</label><br><select id="callingcode" name="callingcode" class="loginfield" style="margin: 2vh 0vw 2vh 1vw;width:5vw;" required><option value="" selected disabled></option><option value="+420">+420</option><option value="+421">+421</option>' /* */ . '</select><input type="number" id="telephone" name="telephone" class="loginfield" style="margin: 2vh 1vw 2vh 0vw;width:15vw;" maxlength="9" minlength="9" required><br><label for="address">' . t("Zadajte svoju adresu") . '</label><br><input type="text" id="address" name="address" class="loginfield" required><br><label for="city">' . t("Zadajte svoje mesto") . '</label><br><input type="text" id="city" name="city" class="loginfield" required><br><label for="country">' . t("Vyberte svoj štát") . '</label><br><select id="country" name="country" class="loginfield" required><option value="" selected disabled></option><option value="Czech republic">Česká republika</option><option value="Slovakia">Slovenská republika</option>' /* */ . '</select><br><label for="nationality">' . t("Vyberte svoju národnosť") . '</label><br><select id="nationality" name="nationality" class="loginfield" required><option value="" selected disabled></option><option value="Czech">Česká</option><option value="Slovak">Slovenská</option>' /* */ . '</select><br><label for="password">' . t("Zadajte svoje heslo") . '</label><br><input type="password" id="passwordx" name="passwordx" class="loginfield" required><br><input type="submit" value="' . t("Zaregistrovať sa") . '"></form>`
                }
                var welcometext = document.querySelector("#welcometext");
                if (welcometext) {
                    welcometext.innerHTML = `<div class="loginalert" style="background-color:red;">' . t("Registrácia bola neúspešná. Skúste to znova.") . '</div>' . t("Vytvorte si nový účet") . '`;
                }
            });
        </script>';
        };
    };
} else { // start
    echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
            var loginpage = document.querySelector("#login-page")
            if (loginpage) {
                loginpage.innerHTML = `<form id="login-page-form" method="post" action="login.php"><label for="email">' . t("Zadajte svoj email") . '</label><br><input type="email" id="email" name="email" class="loginfield" required><br><input type="submit" value="' . t("Pokračovať") . '"></form>`
            }
            var welcometext = document.querySelector("#welcometext")
            if (welcometext) {
                welcometext.innerHTML = "' . t("Prihláste sa alebo si vytvorte nový účet") . '"
            }
            }) </script>';
};
?>
<!DOCTYPE html>
<html lang="sk"> <!-- after translation edit -->
    <head>
        <meta charset="UTF-8">
        <title><?php echo t("Príhlasenie sa") . " | " . t("accomio | Hotely, penzióny a omnoho viac");?></title>
        <link rel="icon" type="image/x-icon" href="styles/icons/icon.ico">
        <link rel='stylesheet' href='styles/basic.css'>
        <link rel='stylesheet' href='styles/user.css'>
        <script src='scripts/basic.js'></script>
    </head>
    <body>
    <div id="copy"></div>
    <header>
            <div class="title" onclick="window.location.href ='/accomio'">accomio</div>
            <nav class="headerbtns">
                <a href="search" class="aimg"><div class="headerdiv" id="hi2">
                    <abbr class="headertext" id="ht2" title="<?php echo t("Vyhľadávanie");?>"><img src="styles/icons/search_world.svg" class="headerimgs"></abbr>
                </div></a>
                <a onclick="langbox()" class="aimg"><div class="headerdiv" id="hi1">
                    <abbr class="headertext" id="ht1" title="<?php echo t("Jazyk");?>"><img src="styles/icons/language.svg" class="headerimgs"></abbr>
                    <div id="hi1style" style="display:inline;"></div>
                </div></a>
                <a href="help" class="aimg"><div class="headerdiv" id="hi2">
                    <abbr class="headertext" id="ht2" title="<?php echo t("Zákaznícka podpora");?>"><img src="styles/icons/help.svg" class="headerimgs"></abbr>
                </div></a>
                <a <?php if (isset($_SESSION["cd"])) {echo "onclick='userbox()'";} else {echo "href='login'";};?> class="aimg"><div class="headerdiv" id="hi2">
                    <abbr class="headertext" id="ht3" style="text-decoration: none; border-bottom: none;" title="<?php if (isset($_SESSION["cd"])) {echo t('Používateľ');} else {echo t('Prihláste sa/Registrujte sa');};?>"><img src="styles/icons/account.svg" class="headerimgs"></abbr>
                    <span id="headername">
                        <?php
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "accomio";
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            if (isset($_SESSION["cd"])) {
                                $sql_name = "SELECT * FROM customers WHERE code = '" . $_SESSION["cd"] . "' AND log = '" . $_SESSION["lg"] . "'";
                                $s_name = $conn->query($sql_name);
                                $result_name = $s_name->fetch_assoc();
                                echo $result_name['name'];
                            };
                        ?>
                    </span>
                </div></a>
            </nav>
            <form id="lang-box" method="get" action="">
                <span class="langtext">Choose your language:</span><br>
                <abbr title="English"><button type="submit" name="lang" value="en" class="langx"><img src="styles/languages/english.svg" id="lang-en" class="langimg"></button></abbr>
                <abbr title="Deutsch"><button type="submit" name="lang" value="de" class="langx"><img src="styles/languages/german.svg" id="lang-de" class="langimg"></button></abbr>
                <abbr title="Slovensky"><button type="submit" name="lang" value="sk" class="langx"><img src="styles/languages/slovak.svg" id="lang-sk" class="langimg"></button></abbr>
            </form>
            <div id="user-box">
                <button class="userbtn" onclick="window.location.href = 'user'"><?php echo t("Môj účet");?></button><br>
                <button class="userbtn" onclick="window.location.href = 'scripts/logout.php'"><?php echo t("Odhlásiť sa");?></button>
            </div>
        </header>

        <div class="welcometext" id="welcometext"></div>
        <div id="login-page"></div>

        <footer id="footer">
            <div class="footer-c1">
                <div class="title" style="font-size: 4vh;">accomio</div>
                <div class="copyright">&copy; 2024 - <?php echo date("Y"); ?> Ján Ivičič<br><?php echo t("Všetky práva vyhradené.");?></div>
            </div>
            <div class="footer-c2">
                <b><?php echo t("Pre zákazníkov");?></b><br>
                <a href="help"><?php echo t("Zákaznícka podpora");?></a><br>
                <a href="terms"><?php echo t("Všeobecné podmienky");?></a><br>
                <a href="privacy"><?php echo t("Ochrana súkromia");?></a>
            </div>
            <div class="footer-c3">
                <b>accomio</b><br>
                <a href="about"><?php echo t("O nás");?></a><br>
                <a href="contact"><?php echo t("Kontakt");?></a><br>
                <a href="partners"><?php echo t("Pre partnerov");?></a>
            </div>
        </footer>
    </body>
</html>