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
    $login = $s_login->fetch_assoc();
    if ($s_login->num_rows == 0) {
        session_destroy();
    } elseif ($login["nationality"] === "admin" || $login["nationality"] === "partner") {
        echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var usersite = document.querySelector("#usersite-all");
                if (usersite) {
                    usersite.innerHTML = `<div style="color:white; text-align:center; font-size: 2.5vh; padding: 8vh 18vw 5vh 18vw;">' . t("Úpravy osobných údajov a hesla na tejto stránke sú dostupné len pre bežných používateľov. Ak ste administrátor alebo partner, prosím kontaktujte Vášho administrátora, ktorý Vám pomôže.") . '</div>`;
                }
            });
        </script>';
    };
} else {
    header("Location: login");
    exit();
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

if (isset($_GET["site"]) && $_GET["site"] == "bh") {
    $site = "bh";
    $sql_ci = "SELECT * FROM customers WHERE code = '" . $_SESSION["cd"] . "' AND log = '" . $_SESSION["lg"] . "'";
    $s_ci = $conn->query($sql_ci);
    $ci = $s_ci->fetch_assoc();
    $sql_bh = "SELECT * FROM bookings WHERE customers_id = '" . $ci["customers_id"]  . "' ORDER BY date_from DESC";
    $s_bh = $conn->query($sql_bh);
    $table = "";
    while ($bh = $s_bh->fetch_assoc()) {
        $sql_h = "SELECT * FROM hotels_info WHERE hotels_id = '" . $bh["hotels_id"] . "'";
        $s_h = $conn->query($sql_h);
        $h = $s_h->fetch_assoc();
        if ($bh["date_to"] < date("Y-m-d")) { // past
            $sql_review = "SELECT * FROM hotels_reviews WHERE bookings_id = '" . $bh["bookings_id"] . "'";
            $s_review = $conn->query($sql_review);
            if ($s_review->num_rows == 0) {
                $review = '<a style="text-decoration:underline;cursor: pointer;color:white;" href="reviews?b=' . $bh["bookings_id"] . '">' . t('PRIDAŤ RECENZIU') . '</a>';
            } else {
                $review = '';
            };
            $table .= '<tr style="background-color:#000000;"><td><a style="text-decoration:underline;cursor: pointer;color:white;" href="' . $h["url"] . '">' . t((string)$h["name"]) . '</a></td><td>' . (new DateTime($bh["date_from"]))->format("d.m.Y") . ' - ' . (new DateTime($bh["date_to"]))->format("d.m.Y") . '</td><td>' . (string)$bh["adults"] . ' + ' . (string)$bh["kids"] . '</td><td>' . (string)$bh["price"] . ' €</td><td>' . $review . '</td></tr>';
        } elseif ($bh["date_from"] < date("Y-m-d")) { // present
            $table .= '<tr style="background-color:white;font-weight:600;"><td><a style="text-decoration:underline;cursor: pointer;color:black;" href="' . $h["url"] . '">' . t((string)$h["name"]) . '</a></td><td style="color:red;">' . (new DateTime($bh["date_from"]))->format("d.m.Y") . ' - ' . (new DateTime($bh["date_to"]))->format("d.m.Y") . '</td><td style="color:black;">' . (string)$bh["adults"] . ' + ' . (string)$bh["kids"] . '</td><td style="color:black;">' . (string)$bh["price"] . ' €</td><td style="color:red;">' . t("PRAJEME PRÍJEMNÝ POBYT :)") . '</td></tr>';
        } else { // future
            $table .= '<tr style="background-color:#404040;font-weight:600;"><td><a style="text-decoration:underline;cursor: pointer;color:white;" href="' . $h["url"] . '">' . t((string)$h["name"]) . '</a></td><td>' . (new DateTime($bh["date_from"]))->format("d.m.Y") . ' - ' . (new DateTime($bh["date_to"]))->format("d.m.Y") . '</td><td>' . (string)$bh["adults"] . ' + ' . (string)$bh["kids"] . '</td><td>' . (string)$bh["price"] . ' €</td><td><a style="text-decoration:underline;cursor: pointer;" onclick="alert(\'' . t("Rezerváciu nie je možné vystornovať online. Kontaktujte hotel, v ktorom je rezervácia vytvorená. Pamätajte však, že budete musieť zaplatiť storno poplatok.") . '\')">' . t("STORNO REZERVÁCIE") . '</a></td></tr>';
        };
    }
    echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var usersite = document.querySelector("#usersite");
                if (usersite) {
                    usersite.innerHTML = `<table class="bookings-table"><tr><th>' . t("Názov hotela") . '</th><th>' . t("Dátum") . '</th><th><abbr title="' . t("dospelí + deti") . '">' . t("Počet osôb") . '</abbr></th><th>' . t("Cena") . '</th><th></th></tr>' . $table . '</table>`;
                }
            });
        </script>';
} elseif (isset($_GET["site"]) && $_GET["site"] == "cp") {
    $site = "cp";
    echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var usersite = document.querySelector("#usersite");
                if (usersite) {
                    usersite.innerHTML = `<form id="login-page-form" method="post" action="user.php"><label for="passwordx">' . t("Zadajte aktuálne heslo") . '</label><br><input type="password" id="passwordx" name="passwordx" class="loginfield" required><br><label for="passworda">' . t("Zadajte nové heslo") . '</label><br><input type="password" id="passworda" name="passworda" class="loginfield" required><br><label for="passwordb">' . t("Zadajte nové heslo ešte raz") . '</label><br><input type="password" id="passwordb" name="passwordb" class="loginfield" required><br><input type="submit" value="' . t("Zmeniť heslo") . '"></form>`
                }
            });
        </script>';
} elseif (isset($_GET["site"]) && $_GET["site"] == "logout") {
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
                    usersite.innerHTML = `<div class="loginalert" style="background-color:red;">' . t("Vaše údaje boli úspešne zmenené.") . '</div><form id="login-page-form" method="post" action="user.php"><label for="emailx">' . t("Váš email:") . '</label><br><input type="email" id="emailx" name="emailx" class="loginfield" value="' . $pd["email"] . '" required readonly><br><label for="name">' . t("Vaše meno:") . '</label><br><input type="text" id="name" name="name" class="loginfield" value="' . $pd["name"] . '" required><br><label for="surname">' . t("Vaše priezvisko:") . '</label><br><input type="text" id="surname" name="surname" class="loginfield" value="' . $pd["surname"] . '" required><br><label for="callingcode">' . t("Vaše telefónne číslo:") . '</label><br><select id="callingcode" name="callingcode" class="loginfield" style="margin: 2vh 0vw 2vh 1vw;width:5vw;" required><option value="" disabled></option><option value="+420" ' . (substr($pd["telephone"], 0, -9) == "+420" ? "selected" : "") . '>+420</option><option value="+421" ' . (substr($pd["telephone"], 0, -9)== "+421" ? "selected" : "") . '>+421</option>' /* */ . '</select><input type="number" id="telephone" name="telephone" class="loginfield" value="' . substr($pd["telephone"], -9) . '" style="margin: 2vh 1vw 2vh 0vw;width:15vw;" maxlength="9" minlength="9" required><br><label for="address">' . t("Vaša adresa:") . '</label><br><input type="text" id="address" name="address" class="loginfield" value="' . $address . '" required><br><label for="city">' . t("Vaše mesto:") . '</label><br><input type="text" id="city" name="city" class="loginfield" value="' . t($city) . '" required><br><label for="country">' . t("Váš štát:") . '</label><br><select id="country" name="country" class="loginfield" required><option value="" disabled></option><option value="Czech republic" ' . ($country == "Czech republic"  ? "selected" : "") . '>' . t("Česká republika") . '</option><option value="Slovakia" ' . ($country == "Slovakia" ? "selected" : "") . '>' . t("Slovenská republika") . '</option>' /* */ . '</select><br><label for="nationality">' . t("Vaša národnosť:") . '</label><br><select id="nationality" name="nationality" class="loginfield" required><option value="" disabled></option><option value="Czech" ' . ($pd["nationality"] == "Czech"  ? "selected" : "") . '>' . t("Česká") . '</option><option value="Slovak"' . ($pd["nationality"] == "Slovak" ? "selected" : "") . '>' . t("Slovenská") . '</option>' /* */ . '</select><br><input type="submit" value="' . t("Aktualizovať") . '"></form>`
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
                    usersite.innerHTML = `<form id="login-page-form" method="post" action="user.php"><div class="loginalert" style="background-color:green;width:64vw;padding:1vh;">' . t("Heslo bolo zmenené úspešne.") . '</div><label for="passwordx">' . t("Zadajte aktuálne heslo") . '</label><br><input type="password" id="passwordx" name="passwordx" class="loginfield" required><br><label for="passworda">' . t("Zadajte nové heslo") . '</label><br><input type="password" id="passworda" name="passworda" class="loginfield" required><br><label for="passwordb">' . t("Zadajte nové heslo ešte raz") . '</label><br><input type="password" id="passwordb" name="passwordb" class="loginfield" required><br><input type="submit" value="' . t("Zmeniť heslo") . '"></form>`
                }
            });
        </script>';
            } else { // error
                echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var usersite = document.querySelector("#usersite");
                if (usersite) {
                    usersite.innerHTML = `<form id="login-page-form" method="post" action="user.php"><div class="loginalert" style="background-color:red;width:64vw;padding:1vh;">' . t("Zmena hesla bola neúspešna. Skúste znova.") . '</div><label for="passwordx">' . t("Zadajte aktuálne heslo") . '</label><br><input type="password" id="passwordx" name="passwordx" class="loginfield" required><br><label for="passworda">' . t("Zadajte nové heslo") . '</label><br><input type="password" id="passworda" name="passworda" class="loginfield" required><br><label for="passwordb">' . t("Zadajte nové heslo ešte raz") . '</label><br><input type="password" id="passwordb" name="passwordb" class="loginfield" required><br><input type="submit" value="' . t("Zmeniť heslo") . '"></form>`
                }
            });
        </script>';
            };
        } else { // incorrect
            echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var usersite = document.querySelector("#usersite");
                if (usersite) {
                    usersite.innerHTML = `<form id="login-page-form" method="post" action="user.php"><div class="loginalert" style="background-color:red;width:64vw;padding:1vh;">' . t("Aktálne heslo nie je správne.") . '</div><label for="passwordx">' . t("Zadajte aktuálne heslo") . '</label><br><input type="password" id="passwordx" name="passwordx" class="loginfield" required><br><label for="passworda">' . t("Zadajte nové heslo") . '</label><br><input type="password" id="passworda" name="passworda" class="loginfield" required><br><label for="passwordb">' . t("Zadajte nové heslo ešte raz") . '</label><br><input type="password" id="passwordb" name="passwordb" class="loginfield" required><br><input type="submit" value="' . t("Zmeniť heslo") . '"></form>`
                }
            });
        </script>';
        };
    } else { // not same
        echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var usersite = document.querySelector("#usersite");
                if (usersite) {
                    usersite.innerHTML = `<form id="login-page-form" method="post" action="user.php"><div class="loginalert" style="background-color:red;width:64vw;padding:1vh;">' . t("Heslá sa nezhodujú.") . '</div><label for="passwordx">' . t("Zadajte aktuálne heslo") . '</label><br><input type="password" id="passwordx" name="passwordx" class="loginfield" required><br><label for="passworda">' . t("Zadajte nové heslo") . '</label><br><input type="password" id="passworda" name="passworda" class="loginfield" required><br><label for="passwordb">' . t("Zadajte nové heslo ešte raz") . '</label><br><input type="password" id="passwordb" name="passwordb" class="loginfield" required><br><input type="submit" value="' . t("Zmeniť heslo") . '"></form>`
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
                    usersite.innerHTML = `<form id="login-page-form" method="post" action="user.php"><label for="emailx">' . t("Váš email:") . '</label><br><input type="email" id="emailx" name="emailx" class="loginfield" value="' . $pd["email"] . '" required readonly><br><label for="name">' . t("Vaše meno:") . '</label><br><input type="text" id="name" name="name" class="loginfield" value="' . $pd["name"] . '" required><br><label for="surname">' . t("Vaše priezvisko:") . '</label><br><input type="text" id="surname" name="surname" class="loginfield" value="' . $pd["surname"] . '" required><br><label for="callingcode">' . t("Vaše telefónne číslo:") . '</label><br><select id="callingcode" name="callingcode" class="loginfield" style="margin: 2vh 0vw 2vh 1vw;width:5vw;" required><option value="" disabled></option><option value="+420" ' . (substr($pd["telephone"], 0, -9) == "+420" ? "selected" : "") . '>+420</option><option value="+421" ' . (substr($pd["telephone"], 0, -9)== "+421" ? "selected" : "") . '>+421</option>' /* */ . '</select><input type="number" id="telephone" name="telephone" class="loginfield" value="' . substr($pd["telephone"], -9) . '" style="margin: 2vh 1vw 2vh 0vw;width:15vw;" maxlength="9" minlength="9" required><br><label for="address">' . t("Vaša adresa:") . '</label><br><input type="text" id="address" name="address" class="loginfield" value="' . $address . '" required><br><label for="city">' . t("Vaše mesto:") . '</label><br><input type="text" id="city" name="city" class="loginfield" value="' . t($city) . '" required><br><label for="country">' . t("Váš štát:") . '</label><br><select id="country" name="country" class="loginfield" required><option value="" disabled></option><option value="Czech republic" ' . ($country == "Czech republic"  ? "selected" : "") . '>' . t("Česká republika") . '</option><option value="Slovakia" ' . ($country == "Slovakia" ? "selected" : "") . '>' . t("Slovenská republika") . '</option>' /* */ . '</select><br><label for="nationality">' . t("Vaša národnosť:") . '</label><br><select id="nationality" name="nationality" class="loginfield" required><option value="" disabled></option><option value="Czech" ' . ($pd["nationality"] == "Czech"  ? "selected" : "") . '>' . t("Česká") . '</option><option value="Slovak"' . ($pd["nationality"] == "Slovak" ? "selected" : "") . '>' . t("Slovenská") . '</option>' /* */ . '</select><br><input type="submit" value="' . t("Aktualizovať") . '"></form>`
                }
            });
        </script>';
};

?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
    <head>
        <meta charset="UTF-8">
        <title><?php echo t("Môj účet") . " | " . t("accomio | Hotely, penzióny a omnoho viac");?></title>
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
        
        <div id="usersite-all">
            <form method="get" class="navbar">
                <button class="navbtn" type="submit" name="site" value="pd" <?php if($site === "pd") {echo "style='background-color:#27f695;'";} ?>><?php echo t("Osobné údaje");?></button>
                <button class="navbtn" type="submit" name="site" value="cp" <?php if($site === "cp") {echo "style='background-color:#27f695;'";} ?>><?php echo t("Zmena hesla");?></button>
                <button class="navbtn" type="submit" name="site" value="bh" <?php if($site === "bh") {echo "style='background-color:#27f695;'";} ?>><?php echo t("História rezervácií");?></button>
                <button class="navbtn" type="submit" name="site" value="logout"><?php echo t("Odhlásiť sa");?></button>
            </form>
            <div id="usersite"></div>
        </div>

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