<!DOCTYPE html>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "accomio";

$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_POST["email"])) {
    $sql_email = "SELECT * FROM customers WHERE email = '" . $_POST["email"] . "'";
    $s_email = $conn->query($sql_email);
    if ($s_email->num_rows == 0) {
        echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
            var loginpage = document.querySelector("#login-page")
            if (loginpage) {
                loginpage.innerHTML = `<form id="login-page-form" method="post" action="login.php"><label for="email">Zadajte svoj email</label><br><input type="email" id="email" name="email" class="loginfield" value="' . $_POST["email"] . '" disabled><br><label for="name">Zadajte svoje meno</label><br><input type="text" id="name" name="name" class="loginfield"><br><label for="surname">Zadajte svoje priezvisko</label><br><input type="text" id="surname" name="surname" class="loginfield"><br><label for="callingcode">Zadajte svoje telefónne číslo</label><br><select id="callingcode" name="callingcode" class="loginfield" style="margin: 2vh 0vw 2vh 1vw;width:5vw;"><option value="" selected disabled></option><option value="+420">+420</option><option value="+421">+421</option>' /* */ . '</select><input type="number" id="telephone" name="telephone" class="loginfield" style="margin: 2vh 1vw 2vh 0vw;width:15vw;"><br><label for="surname">Zadajte svoju adresu</label><br><input type="text" id="adress" name="adress" class="loginfield"><br><label for="surname">Zadajte svoje heslo</label><br><input type="password" id="password" name="password" class="loginfield"><br><input type="submit" value="Zaregistrovať sa"></form>`
            }
            var welcometext = document.querySelector("#welcometext")
            if (welcometext) {
                welcometext.innerHTML = "Vytvorte si nový účet"
            }
            }) </script>';
    } else {
        echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
            var loginpage = document.querySelector("#login-page")
            if (loginpage) {
                loginpage.innerHTML = `<form id="login-page-form" method="post" action="login.php"><label for="email">Zadajte svoj email</label><br><input type="email" id="email" name="email" class="loginfield" value="' . $_POST["email"] . '" disabled><br><label for="password">Zadajte svoje heslo</label><br><input type="password" id="password" name="password" class="loginfield"><br><input type="submit" value="Prihlásiť sa"></form>`
            }
            var welcometext = document.querySelector("#welcometext")
            if (welcometext) {
                welcometext.innerHTML = "Prihláste sa"
            }
            }) </script>';
    }
} elseif (isset($_POST["password"])) {

} elseif (isset($_POST["name"])) {
    
} else {
    echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
            var loginpage = document.querySelector("#login-page")
            if (loginpage) {
                loginpage.innerHTML = `<form id="login-page-form" method="post" action="login.php"><label for="email">Zadajte svoj email</label><br><input type="email" id="email" name="email" class="loginfield"><br><input type="submit" value="Pokračovať"></form>`
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