<?php
session_start();
?>
<!DOCTYPE html>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "accomio";

$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_POST["email"])) { // email
    $sql_email = "SELECT * FROM customers WHERE email = '" . $_POST["email"] . "'";
    $s_email = $conn->query($sql_email);
    if ($s_email->num_rows == 0) { // reg form
        echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
            var loginpage = document.querySelector("#login-page")
            if (loginpage) {
                loginpage.innerHTML = `<form id="login-page-form" method="post" action="login.php"><label for="emailx">Zadajte svoj email</label><br><input type="email" id="emailx" name="emailx" class="loginfield" value="' . $_POST["email"] . '" readonly required><br><label for="name">Zadajte svoje meno</label><br><input type="text" id="name" name="name" class="loginfield" required><br><label for="surname">Zadajte svoje priezvisko</label><br><input type="text" id="surname" name="surname" class="loginfield" required><br><label for="callingcode">Zadajte svoje telefónne číslo</label><br><select id="callingcode" name="callingcode" class="loginfield" style="margin: 2vh 0vw 2vh 1vw;width:5vw;" required><option value="" selected disabled></option><option value="+420">+420</option><option value="+421">+421</option>' /* */ . '</select><input type="number" id="telephone" name="telephone" class="loginfield" style="margin: 2vh 1vw 2vh 0vw;width:15vw;" maxlength="9" minlength="9" required><br><label for="address">Zadajte svoju adresu</label><br><input type="text" id="address" name="address" class="loginfield" required><br><label for="city">Zadajte svoje mesto</label><br><input type="text" id="city" name="city" class="loginfield" required><br><label for="country">Vyberte svoj štát</label><br><select id="country" name="country" class="loginfield" required><option value="" selected disabled></option><option value="Czech republic">Česká republika</option><option value="Slovakia">Slovenská republika</option>' /* */ . '</select><br><label for="nationality">Vyberte svoju národnosť</label><br><select id="nationality" name="nationality" class="loginfield" required><option value="" selected disabled></option><option value="Czech">Česká</option><option value="Slovak">Slovenská</option>' /* */ . '</select><br><label for="password">Zadajte svoje heslo</label><br><input type="password" id="passwordx" name="passwordx" class="loginfield" required><br><input type="submit" value="Zaregistrovať sa"></form>`
            }
            var welcometext = document.querySelector("#welcometext")
            if (welcometext) {
                welcometext.innerHTML = "Vytvorte si nový účet"
            }
            }) </script>';
    } else { // log form
        echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
            var loginpage = document.querySelector("#login-page")
            if (loginpage) {
                loginpage.innerHTML = `<form id="login-page-form" method="post" action="login.php"><label for="emailx">Zadajte svoj email</label><br><input type="email" id="emailx" name="emailx" class="loginfield" value="' . $_POST["email"] . '" readonly required><br><label for="password">Zadajte svoje heslo</label><br><input type="password" id="password" name="password" class="loginfield" required><br><input type="submit" value="Prihlásiť sa"></form>`
            }
            var welcometext = document.querySelector("#welcometext")
            if (welcometext) {
                welcometext.innerHTML = "Prihláste sa"
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
                        loginpage.innerHTML = `<form id='login-page-form' method='post' action='login.php'><label for='emailx'>Zadajte svoj email</label><br><input type='email' id='emailx' name='emailx' class='loginfield' value='" . $_POST["email"] . "' readonly required><br><label for='password'>Zadajte svoje heslo</label><br><input type='password' id='password' name='password' class='loginfield' required><br><input type='submit' value='Prihlásiť sa'></form>`;
                    }
                    var welcometext = document.querySelector('#welcometext');
                    if (welcometext) {
                        welcometext.innerHTML = `<div class='loginalert' style='background-color:red;'>Prihlásenie bolo. Skúste to znova.</div>Prihláste sa`;
                </script>";
        };
    } else { // wrong
        echo "<script>
            document.addEventListener('DOMContentLoaded', () => {
                var loginpage = document.querySelector('#login-page');
                if (loginpage) {
                    loginpage.innerHTML = `<form id='login-page-form' method='post' action='login.php'><label for='emailx'>Zadajte svoj email</label><br><input type='email' id='emailx' name='emailx' class='loginfield' value='" . $_POST["email"] . "' required><br><label for='password'>Zadajte svoje heslo</label><br><input type='password' id='password' name='password' class='loginfield' required><br><input type='submit' value='Prihlásiť sa'></form>`;
                }
                var welcometext = document.querySelector('#welcometext');
                if (welcometext) {
                    welcometext.innerHTML = `<div class='loginalert' style='background-color:red;'>Nesprávne heslo. Skúste to znova.</div>Prihláste sa`;
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
                    loginpage.innerHTML = `<form id='login-page-form' method='post' action='login.php'><label for='emailx'>Zadajte svoj email</label><br><input type='email' id='emailx' name='emailx' class='loginfield' value='" . $_POST["emailx"] . "' required><br><label for='password'>Zadajte svoje heslo</label><br><input type='password' id='password' name='password' class='loginfield' required><br><input type='submit' value='Prihlásiť sa'></form>`;
                }
                var welcometext = document.querySelector('#welcometext');
                if (welcometext) {
                    welcometext.innerHTML = `<div class='loginalert' style='background-color:red;'>Email je už registroavný. Prosím prihláste sa.</div>Prihláste sa`;
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
                        loginpage.innerHTML = `<form id='login-page-form' method='post' action='login.php'><label for='emailx'>Zadajte svoj email</label><br><input type='email' id='emailx' name='emailx' class='loginfield' value='" . $_POST["emailx"] . "' required><br><label for='password'>Zadajte svoje heslo</label><br><input type='password' id='password' name='password' class='loginfield' required><br><input type='submit' value='Prihlásiť sa'></form>`;
                    }
                    var welcometext = document.querySelector('#welcometext');
                    if (welcometext) {
                        welcometext.innerHTML = `<div class='loginalert' style='background-color:green;'>Úspešne ste sa zaregistrovali. Prosím prihláste sa.</div>Prihláste sa`;
                    }
                });
            </script>";
        } else { // error
            echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var loginpage = document.querySelector("#login-page");
                if (loginpage) {
                    loginpage.innerHTML = `<form id="login-page-form" method="post" action="login.php"><label for="emailx">Zadajte svoj email</label><br><input type="email" id="emailx" name="emailx" class="loginfield" value="' . $_POST["email"] . '" readonly required><br><label for="name">Zadajte svoje meno</label><br><input type="text" id="name" name="name" class="loginfield" required><br><label for="surname">Zadajte svoje priezvisko</label><br><input type="text" id="surname" name="surname" class="loginfield" required><br><label for="callingcode">Zadajte svoje telefónne číslo</label><br><select id="callingcode" name="callingcode" class="loginfield" style="margin: 2vh 0vw 2vh 1vw;width:5vw;" required><option value="" selected disabled></option><option value="+420">+420</option><option value="+421">+421</option>' /* */ . '</select><input type="number" id="telephone" name="telephone" class="loginfield" style="margin: 2vh 1vw 2vh 0vw;width:15vw;" maxlength="9" minlength="9" required><br><label for="address">Zadajte svoju adresu</label><br><input type="text" id="address" name="address" class="loginfield" required><br><label for="city">Zadajte svoje mesto</label><br><input type="text" id="city" name="city" class="loginfield" required><br><label for="country">Vyberte svoj štát</label><br><select id="country" name="country" class="loginfield" required><option value="" selected disabled></option><option value="Czech republic">Česká republika</option><option value="Slovakia">Slovenská republika</option>' /* */ . '</select><br><label for="nationality">Vyberte svoju národnosť</label><br><select id="nationality" name="nationality" class="loginfield" required><option value="" selected disabled></option><option value="Czech">Česká</option><option value="Slovak">Slovenská</option>' /* */ . '</select><br><label for="password">Zadajte svoje heslo</label><br><input type="password" id="passwordx" name="passwordx" class="loginfield" required><br><input type="submit" value="Zaregistrovať sa"></form>`
                }
                var welcometext = document.querySelector("#welcometext");
                if (welcometext) {
                    welcometext.innerHTML = `<div class="loginalert" style="background-color:red;">Registrácia bola neúspečná. Skúste to znova.</div>Prihláste sa`;
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
                loginpage.innerHTML = `<form id="login-page-form" method="post" action="login.php"><label for="email">Zadajte svoj email</label><br><input type="email" id="email" name="email" class="loginfield" required><br><input type="submit" value="Pokračovať"></form>`
            }
            var welcometext = document.querySelector("#welcometext")
            if (welcometext) {
                welcometext.innerHTML = "Prihláste sa alebo si vytvorte nový účet"
            }
            }) </script>';
};
?>
<html lang="sk"> <!-- after translation edit -->
    <head>
        <meta charset="UTF-8">
        <title>accomio | Hotely, penzióny a omnoho viac</title>
        <link rel="icon" type="image/x-icon" href="styles/icons/icon.ico">
        <link rel='stylesheet' href='styles/basic.css'>
        <link rel='stylesheet' href='styles/login.css'>
        <script src='scripts/basic.js'></script>
    </head>
    <body>
    <header>
            <div class="title" onclick="window.location.href ='/accomio'">accomio</div>
            <nav class="headerbtns">
                <a onclick="langbox()" class="aimg"><div class="headerdiv" id="hi1">
                    <abbr class="headertext" id="ht1" title="Zmeniť jazyk"><img src="styles/icons/language.svg" class="headerimgs"></abbr>
                    <div id="hi1style" style="display:inline;"></div>
                </div></a>
                <a href="help" class="aimg"><div class="headerdiv" id="hi2">
                    <abbr class="headertext" id="ht2" title="Zákaznícka podpora"><img src="styles/icons/help.svg" class="headerimgs"></abbr>
                </div></a>
                <a href="login" class="aimg"><div class="headerdiv" id="hi2">
                    <abbr class="headertext" id="ht2" title="Prihláste sa/Registrujte sa"><img src="styles/icons/account.svg" class="headerimgs"></abbr>
                </div></a>
            </nav>
            <div id="lang-box">
                <span class="langtext">Choose your language:</span><br>
                <abbr title="English"><img src="styles/languages/english.svg" id="lang-en" class="langimg"></abbr>
                <abbr title="Deutsch"><img src="styles/languages/german.svg" id="lang-de" class="langimg"></abbr>
                <abbr title="Slovensky"><img src="styles/languages/slovak.svg" id="lang-sk" class="langimg"></abbr>
                <abbr title="Česky"><img src="styles/languages/czech.svg" id="lang-cz" class="langimg"></abbr>
            </div>
        </header>
        <div class="welcometext" id="welcometext"></div>
        <div id="login-page"></div>
        <div id="footer">
            <div class="footer-c1">
                <div class="title" style="font-size: 4vh;">accomio</div>
                <div class="copyright">&copy; 2024 Ján Ivičič<br>Všetky práva vyhradené.</div>
            </div>
            <div class="footer-c2">
                <b>Pre zákazníkov</b><br>
                <a href="help">Podpora</a><br>
                <a href="terms">Všeobecné podmienky</a><br>
                <a href="privacy">Ochrana súkromia</a>
            </div>
            <div class="footer-c3">
                <b>accomio</b><br>
                <a href="about">O nás</a><br>
                <a href="contact">Kontakt</a><br>
                <a href="partners">Pre partnerov</a>
            </div>
        </div>
    </body>
</html>