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

if (isset($_POST["bh"])) {
    $site = "bh";
    $sql_ci = "SELECT * FROM customers WHERE code = '" . $_SESSION["cd"] . "' AND log = '" . $_SESSION["lg"] . "'";
    $s_ci = $conn->query($sql_ci);
    $ci = $s_ci->fetch_assoc();
    $sql_bh = "SELECT * FROM bookings WHERE customers_id = '" . $ci["customers_id"]  . "'";
    $s_bh = $conn->query($sql_bh);
    $table = "";
    while ($bh = $s_bh->fetch_assoc()) {
        $sql_h = "SELECT * FROM hotels_info WHERE hotels_id = '" . $bh["hotels_id"] . "'";
        $s_h = $conn->query($sql_h);
        $h = $s_h->fetch_assoc();
        $table .= '<tr><td><a style="text-decoration:underline;cursor: pointer;color:white;" href="' . $h["url"] . '">' . (string)$h["name"] . '</a></td><td>' . (new DateTime($bh["date_from"]))->format("d.m.Y") . ' - ' . (new DateTime($bh["date_to"]))->format("d.m.Y") . '</td><td>' . (string)$bh["adults"] . ' + ' . (string)$bh["kids"] . '</td><td>' . (string)$bh["price"] . ' €</td><td><a style="text-decoration:underline;cursor: pointer;" onclick="alert(\'Rezerváciu nie je možné vystornovať online. Kontaktuje hotel, v ktorom je rezervácia vytvorená. Pamätajte však, že budete musieť zaplatiť storno poplatok.\')">STORNO REZERVÁCIE</a></td></tr>';
    }
    echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var usersite = document.querySelector("#usersite");
                if (usersite) {
                    usersite.innerHTML = `<table class="bookings-table"><tr><th>Názov hotela</th><th>Dátum</th><th><abbr title="dospelí + deti">Počet osôb</abbr></th><th>Cena</th><th></th></tr>' . $table . '</table>`;
                }
            });
        </script>';
} elseif (isset($_POST["cp"])) {
    $site = "cp";
    echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var usersite = document.querySelector("#usersite");
                if (usersite) {
                    usersite.innerHTML = `<form id="login-page-form" method="post" action="user.php"><label for="passwordx">Zadajte aktuálne heslo</label><br><input type="password" id="passwordx" name="passwordx" class="loginfield" required><br><label for="passworda">Zadajte nové heslo</label><br><input type="password" id="passworda" name="passworda" class="loginfield" required><br><label for="passwordb">Zadajte nové heslo ešte raz</label><br><input type="password" id="passwordb" name="passwordb" class="loginfield" required><br><input type="submit" value="Zmeniť heslo"></form>`
                }
            });
        </script>';
} elseif (isset($_POST["logout"])) {
    header("Location: scripts/logout.php");
} elseif (isset($_POST["emailx"])) {
    $site = "pd";
    $sql_pd_up = "UPDATE customers SET name = '" . $_POST["name"] . "', surname = '" . $_POST["surname"] . "', email = '" . $_POST["emailx"] . "', telephone = '" . $_POST["callingcode"] . $_POST["telephone"] . "', address = '" . $_POST["address"] . ", " . $_POST["city"] . ", " . $_POST["country"] . "', nationality = '" . $_POST["nationality"] . "' WHERE code = '" . $_SESSION["cd"] . "' AND log = '" . $_SESSION["lg"] . "'";
    $s_pd_up = $conn->query($sql_pd_up);

    $sql_pd = "SELECT * FROM customers WHERE code = '" . $_SESSION["cd"] . "' AND log = '" . $_SESSION["lg"] . "'";
    $s_pd = $conn->query($sql_pd);
    $pd = $s_pd->fetch_assoc();

    $first = strpos($pd["address"], ',');
    $second = strpos($pd["address"], ',', $first + 1);
    $address = trim(substr($pd["address"], 0, $first));
    $city = trim(substr($pd["address"], $first + 1, $second - $first - 1));
    $country = trim(substr($pd["address"], $second + 1));

    echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var usersite = document.querySelector("#usersite");
                if (usersite) {
                    usersite.innerHTML = `<div class="loginalert" style="background-color:red;">Vaše údaje boli úspešne zmenené.</div><form id="login-page-form" method="post" action="user.php"><label for="emailx">Váš email</label><br><input type="email" id="emailx" name="emailx" class="loginfield" value="' . $pd["email"] . '" required readonly><br><label for="name">Vaše meno</label><br><input type="text" id="name" name="name" class="loginfield" value="' . $pd["name"] . '" required><br><label for="surname">Vaše priezvisko</label><br><input type="text" id="surname" name="surname" class="loginfield" value="' . $pd["surname"] . '" required><br><label for="callingcode">Vaše telefónne číslo</label><br><select id="callingcode" name="callingcode" class="loginfield" style="margin: 2vh 0vw 2vh 1vw;width:5vw;" required><option value="" disabled></option><option value="+420" ' . (substr($pd["telephone"], 0, -9) == "+420" ? "selected" : "") . '>+420</option><option value="+421" ' . (substr($pd["telephone"], 0, -9)== "+421" ? "selected" : "") . '>+421</option>' /* */ . '</select><input type="number" id="telephone" name="telephone" class="loginfield" value="' . substr($pd["telephone"], -9) . '" style="margin: 2vh 1vw 2vh 0vw;width:15vw;" maxlength="9" minlength="9" required><br><label for="address">Vaša adresa</label><br><input type="text" id="address" name="address" class="loginfield" value="' . $address . '" required><br><label for="city">Vaše mesto</label><br><input type="text" id="city" name="city" class="loginfield" value="' . $city . '" required><br><label for="country">Váš štát</label><br><select id="country" name="country" class="loginfield" required><option value="" disabled></option><option value="Czech republic" ' . ($country == "Czech republic"  ? "selected" : "") . '>Česká republika</option><option value="Slovakia" ' . ($country == "Slovakia" ? "selected" : "") . '>Slovenská republika</option>' /* */ . '</select><br><label for="nationality">Vaša národnosť</label><br><select id="nationality" name="nationality" class="loginfield" required><option value="" disabled></option><option value="Czech" ' . ($pd["nationality"] == "Czech"  ? "selected" : "") . '>Česká</option><option value="Slovak"' . ($pd["nationality"] == "Slovak" ? "selected" : "") . '>Slovenská</option>' /* */ . '</select><br><input type="submit" value="Aktualizovať"></form>`
                }
            });
        </script>';
} elseif (isset($_POST["passwordx"])) {
    $site = "cp";
    if ($_POST["passworda"] == $_POST["passwordb"]) { // same
        $sql_old = "SELECT * FROM customers WHERE code = '" . $_SESSION["cd"] . "' AND log = '" . $_SESSION["lg"] . "'";
        $s_old = $conn->query($sql_old);
        $old = $s_old->fetch_assoc();
        if (password_verify($_POST["passwordx"], $old["password"])) { // correct
            $sql_new = "UPDATE customers SET password = '" . password_hash($_POST["passworda"], PASSWORD_DEFAULT) . "' WHERE code = '" . $_SESSION["cd"] . "' AND log = '" . $_SESSION["lg"] . "'";
            $s_new = $conn->query($sql_new);
            if ($s_new) { // success
                echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var usersite = document.querySelector("#usersite");
                if (usersite) {
                    usersite.innerHTML = `<form id="login-page-form" method="post" action="user.php"><div class="loginalert" style="background-color:green;width:64vw;padding:1vh;">Heslo zmenené úspešne.</div><label for="passwordx">Zadajte aktuálne heslo</label><br><input type="password" id="passwordx" name="passwordx" class="loginfield" required><br><label for="passworda">Zadajte nové heslo</label><br><input type="password" id="passworda" name="passworda" class="loginfield" required><br><label for="passwordb">Zadajte nové heslo ešte raz</label><br><input type="password" id="passwordb" name="passwordb" class="loginfield" required><br><input type="submit" value="Zmeniť heslo"></form>`
                }
            });
        </script>';
            } else { // error
                echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var usersite = document.querySelector("#usersite");
                if (usersite) {
                    usersite.innerHTML = `<form id="login-page-form" method="post" action="user.php"><div class="loginalert" style="background-color:red;width:64vw;padding:1vh;">Zmena hesla bola neúspešna. Skúste znova.</div><label for="passwordx">Zadajte aktuálne heslo</label><br><input type="password" id="passwordx" name="passwordx" class="loginfield" required><br><label for="passworda">Zadajte nové heslo</label><br><input type="password" id="passworda" name="passworda" class="loginfield" required><br><label for="passwordb">Zadajte nové heslo ešte raz</label><br><input type="password" id="passwordb" name="passwordb" class="loginfield" required><br><input type="submit" value="Zmeniť heslo"></form>`
                }
            });
        </script>';
            };
        } else { // incorrect
            echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var usersite = document.querySelector("#usersite");
                if (usersite) {
                    usersite.innerHTML = `<form id="login-page-form" method="post" action="user.php"><div class="loginalert" style="background-color:red;width:64vw;padding:1vh;">Aktálne heslo nie je správne</div><label for="passwordx">Zadajte aktuálne heslo</label><br><input type="password" id="passwordx" name="passwordx" class="loginfield" required><br><label for="passworda">Zadajte nové heslo</label><br><input type="password" id="passworda" name="passworda" class="loginfield" required><br><label for="passwordb">Zadajte nové heslo ešte raz</label><br><input type="password" id="passwordb" name="passwordb" class="loginfield" required><br><input type="submit" value="Zmeniť heslo"></form>`
                }
            });
        </script>';
        };
    } else { // not same
        echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var usersite = document.querySelector("#usersite");
                if (usersite) {
                    usersite.innerHTML = `<form id="login-page-form" method="post" action="user.php"><div class="loginalert" style="background-color:red;width:64vw;padding:1vh;">Heslá sa nezhodujú.</div><label for="passwordx">Zadajte aktuálne heslo</label><br><input type="password" id="passwordx" name="passwordx" class="loginfield" required><br><label for="passworda">Zadajte nové heslo</label><br><input type="password" id="passworda" name="passworda" class="loginfield" required><br><label for="passwordb">Zadajte nové heslo ešte raz</label><br><input type="password" id="passwordb" name="passwordb" class="loginfield" required><br><input type="submit" value="Zmeniť heslo"></form>`
                }
            });
        </script>';
    };
} else{
    $site = "pd";
    $sql_pd = "SELECT * FROM customers WHERE code = '" . $_SESSION["cd"] . "' AND log = '" . $_SESSION["lg"] . "'";
    $s_pd = $conn->query($sql_pd);
    $pd = $s_pd->fetch_assoc();

    $first = strpos($pd["address"], ',');
    $second = strpos($pd["address"], ',', $first + 1);
    $address = trim(substr($pd["address"], 0, $first));
    $city = trim(substr($pd["address"], $first + 1, $second - $first - 1));
    $country = trim(substr($pd["address"], $second + 1));

    echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var usersite = document.querySelector("#usersite");
                if (usersite) {
                    usersite.innerHTML = `<form id="login-page-form" method="post" action="user.php"><label for="emailx">Váš email</label><br><input type="email" id="emailx" name="emailx" class="loginfield" value="' . $pd["email"] . '" required readonly><br><label for="name">Vaše meno</label><br><input type="text" id="name" name="name" class="loginfield" value="' . $pd["name"] . '" required><br><label for="surname">Vaše priezvisko</label><br><input type="text" id="surname" name="surname" class="loginfield" value="' . $pd["surname"] . '" required><br><label for="callingcode">Vaše telefónne číslo</label><br><select id="callingcode" name="callingcode" class="loginfield" style="margin: 2vh 0vw 2vh 1vw;width:5vw;" required><option value="" disabled></option><option value="+420" ' . (substr($pd["telephone"], 0, -9) == "+420" ? "selected" : "") . '>+420</option><option value="+421" ' . (substr($pd["telephone"], 0, -9)== "+421" ? "selected" : "") . '>+421</option>' /* */ . '</select><input type="number" id="telephone" name="telephone" class="loginfield" value="' . substr($pd["telephone"], -9) . '" style="margin: 2vh 1vw 2vh 0vw;width:15vw;" maxlength="9" minlength="9" required><br><label for="address">Vaša adresa</label><br><input type="text" id="address" name="address" class="loginfield" value="' . $address . '" required><br><label for="city">Vaše mesto</label><br><input type="text" id="city" name="city" class="loginfield" value="' . $city . '" required><br><label for="country">Váš štát</label><br><select id="country" name="country" class="loginfield" required><option value="" disabled></option><option value="Czech republic" ' . ($country == "Czech republic"  ? "selected" : "") . '>Česká republika</option><option value="Slovakia" ' . ($country == "Slovakia" ? "selected" : "") . '>Slovenská republika</option>' /* */ . '</select><br><label for="nationality">Vaša národnosť</label><br><select id="nationality" name="nationality" class="loginfield" required><option value="" disabled></option><option value="Czech" ' . ($pd["nationality"] == "Czech"  ? "selected" : "") . '>Česká</option><option value="Slovak"' . ($pd["nationality"] == "Slovak" ? "selected" : "") . '>Slovenská</option>' /* */ . '</select><br><input type="submit" value="Aktualizovať"></form>`
                }
            });
        </script>';
};

?>
<!DOCTYPE html>
<html lang="sk"> <!-- after translation edit -->
    <head>
        <meta charset="UTF-8">
        <title>Môj účet | accomio | Hotely, penzióny a omnoho viac</title>
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
                    <abbr class="headertext" id="ht2" title="Vyhľadávanie"><img src="styles/icons/search_world.svg" class="headerimgs"></abbr>
                </div></a>
                <a onclick="langbox()" class="aimg"><div class="headerdiv" id="hi1">
                    <abbr class="headertext" id="ht1" title="Zmeniť jazyk"><img src="styles/icons/language.svg" class="headerimgs"></abbr>
                    <div id="hi1style" style="display:inline;"></div>
                </div></a>
                <a href="help" class="aimg"><div class="headerdiv" id="hi2">
                    <abbr class="headertext" id="ht2" title="Zákaznícka podpora"><img src="styles/icons/help.svg" class="headerimgs"></abbr>
                </div></a>
                <a <?php if (isset($_SESSION["cd"])) {echo "onclick='userbox()'";} else {echo "href='login'";};?> class="aimg"><div class="headerdiv" id="hi2">
                    <abbr class="headertext" id="ht3" style="text-decoration: none; border-bottom: none;" title="<?php if (isset($_SESSION["cd"])) {echo "Používateľ";} else {echo "Prihláste sa/Registrujte sa";};?>"><img src="styles/icons/account.svg" class="headerimgs"></abbr>
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
            <div id="lang-box">
                <span class="langtext">Choose your language:</span><br>
                <abbr title="English"><img src="styles/languages/english.svg" id="lang-en" class="langimg"></abbr>
                <abbr title="Deutsch"><img src="styles/languages/german.svg" id="lang-de" class="langimg"></abbr>
                <abbr title="Slovensky"><img src="styles/languages/slovak.svg" id="lang-sk" class="langimg"></abbr>
                <abbr title="Česky"><img src="styles/languages/czech.svg" id="lang-cz" class="langimg"></abbr>
            </div>
            <div id="user-box">
                <button class="userbtn" onclick="window.location.href = 'user'">Môj účet</button><br>
                <button class="userbtn" onclick="window.location.href = 'scripts/logout.php'">Odhlásiť sa</button>
            </div>
        </header>
        <form method="post" class="navbar">
            <button class="navbtn" type="submit" name="pd" <?php if($site === "pd") {echo "style='background-color:#27f695;'";} ?>>Osobné údaje</button>
            <button class="navbtn" type="submit" name="cp" <?php if($site === "cp") {echo "style='background-color:#27f695;'";} ?>>Zmena hesla</button>
            <button class="navbtn" type="submit" name="bh" <?php if($site === "bh") {echo "style='background-color:#27f695;'";} ?>>História rezervácií</button>
            <button class="navbtn" type="submit" name="logout">Odhlásiť sa</button>
        </form>
        <div id="usersite"></div>
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