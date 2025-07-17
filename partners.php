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
        header("Location: /accomio");
    } elseif ($login["nationality"] != "partner") {
        if ($login["nationality"] == "admin") {
            header("Location: admin");
        } else {
            header("Location: /accomio");
        }
    }
} else {
    header("Location: login");
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

if (isset($_GET['site']) && $_GET['site'] === "res") {
    $site = "res";
    $sql_ci = "SELECT * FROM customers WHERE code = '" . $_SESSION["cd"] . "' AND log = '" . $_SESSION["lg"] . "'";
    $s_ci = $conn->query($sql_ci);
    $bhi = $s_ci->fetch_assoc();
    $sql_bh = "SELECT * FROM bookings WHERE hotels_id = '" . $bhi["surname"]  . "' ORDER BY date_from DESC";
    $s_bh = $conn->query($sql_bh);
    $table = "";
    while ($bh = $s_bh->fetch_assoc()) {
        if ($bh["date_to"] < date("Y-m-d")) { // past
            $table .= '<tr style="background-color:#000000;"><td>' . $bh["name"] . " " . $bh["surname"] . '</td><td>' . $bh["email"] . ', ' . $bh["telephone"] . '</td><td>' . (new DateTime($bh["date_from"]))->format("d.m.Y") . ' - ' . (new DateTime($bh["date_to"]))->format("d.m.Y") . '</td><td>' . (string)$bh["adults"] . ' + ' . (string)$bh["kids"] . '</td><td>' . (string)$bh["price"] . ' €</td><td></td></tr>';
        } elseif ($bh["date_from"] < date("Y-m-d")) { // present
            $table .= '<tr style="background-color:white;font-weight:600;"><td>' . $bh["name"] . " " . $bh["surname"] . '</td><td>' . $bh["email"] . ', ' . $bh["telephone"] . '</td><td style="color:red;">' . (new DateTime($bh["date_from"]))->format("d.m.Y") . ' - ' . (new DateTime($bh["date_to"]))->format("d.m.Y") . '</td><td style="color:black;">' . (string)$bh["adults"] . ' + ' . (string)$bh["kids"] . '</td><td style="color:black;">' . (string)$bh["price"] . ' €</td><td style="color:red;">' . t("POBYT PRÁVE PREBIEHA") . '</td></tr>';
        } else { // future
            $table .= '<tr style="background-color:#404040;font-weight:600;"><td>' . $bh["name"] . " " . $bh["surname"] . '</td><td>' . $bh["email"] . ', ' . $bh["telephone"] . '</td><td>' . (new DateTime($bh["date_from"]))->format("d.m.Y") . ' - ' . (new DateTime($bh["date_to"]))->format("d.m.Y") . '</td><td>' . (string)$bh["adults"] . ' + ' . (string)$bh["kids"] . '</td><td>' . (string)$bh["price"] . ' €</td><td><form method="post" action=""><details><summary onclick="alert(\'' . t("Nezabudnite, že je Vašou povinnosťou informvať zákazníka a vrátiť mu všetky zaplatené poplatky.") . '\')" style="text-decoration:underline;cursor: pointer;">' . t("STORNO REZERVÁCIE") . '</summary><p><button type="submit" style="text-decoration:underline;cursor: pointer;" class="bookings-input" name="cancel" value="' . (string)$bh["bookings_id"] . '">' . t("POTVRDIŤ") . '</button></p></details></form></td></tr>';
        };
    }
    echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var partnersite = document.querySelector("#partnersite");
                if (partnersite) {
                    partnersite.innerHTML = `<table class="bookings-table"><tr><th>' . t("Meno") . '</th><th>' . t("Kontakt") . '</th><th>Dátum</th><th><abbr title="' . t("dospelí + deti") . '">' . t("Počet osôb") . '</abbr></th><th>' . t("Cena") . '</th><th></th></tr>' . $table . '</table>`;
                }
            });
        </script>';
} elseif (isset($_GET['site']) && $_GET['site'] === "rev") {
    $site = "rev";
    $sql_ci = "SELECT * FROM customers WHERE code = '" . $_SESSION["cd"] . "' AND log = '" . $_SESSION["lg"] . "'";
    $s_ci = $conn->query($sql_ci);
    $bhi = $s_ci->fetch_assoc();
    $sql_re = "SELECT * FROM hotels_reviews WHERE hotels_id = '" . $bhi["surname"]  . "' ORDER BY date DESC";
    $s_re = $conn->query($sql_re);
    $table = "";
    while ($re = $s_re->fetch_assoc()) {
        if ($re["name"] == "Anonymný hosť") {
            $nameee = t("Anonymný hosť");
        } else {
            $nameee = $re["name"];
        };
            $table .= '<tr><td>' . (new DateTime($re["date"]))->format("d.m.Y") . '</td><td style="font-weight: 600;">' . $re["rating"] . ' ★</td><td>' . $re["review"] . '</td><td>' . $nameee . '</td></tr>';
    }
    $sql_h = "SELECT * FROM hotels_info WHERE hotels_id = '" . $bhi["surname"] . "'";
    $s_h = $conn->query($sql_h);
    $h = $s_h->fetch_assoc();
    echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var partnersite = document.querySelector("#partnersite");
                if (partnersite) {
                    partnersite.innerHTML = `<div style="text-align:center;font-size:3vh;color:white">' . t("Priemerné hodnotenie Vášho hotela:") . ' <span style="font-weight:600">' . $h["rating"] . ' ★</span></div><table class="bookings-table"><tr><th>' . t("Dátum") . '</th><th>' . t("Hviezdičky") . '</th><th>' . t("Hodnotenie") . '</th><th>' . t("Meno") . '</th></tr>' . $table . '</table>`;
                }
            });
        </script>';
} else {
    $site = "res";
    $sql_ci = "SELECT * FROM customers WHERE code = '" . $_SESSION["cd"] . "' AND log = '" . $_SESSION["lg"] . "'";
    $s_ci = $conn->query($sql_ci);
    $bhi = $s_ci->fetch_assoc();
    $sql_bh = "SELECT * FROM bookings WHERE hotels_id = '" . $bhi["surname"]  . "' ORDER BY date_from DESC";
    $s_bh = $conn->query($sql_bh);
    $table = "";
    while ($bh = $s_bh->fetch_assoc()) {
        if ($bh["date_to"] < date("Y-m-d")) { // past
            $table .= '<tr style="background-color:#000000;"><td>' . $bh["name"] . " " . $bh["surname"] . '</td><td>' . $bh["email"] . ', ' . $bh["telephone"] . '</td><td>' . (new DateTime($bh["date_from"]))->format("d.m.Y") . ' - ' . (new DateTime($bh["date_to"]))->format("d.m.Y") . '</td><td>' . (string)$bh["adults"] . ' + ' . (string)$bh["kids"] . '</td><td>' . (string)$bh["price"] . ' €</td><td></td></tr>';
        } elseif ($bh["date_from"] < date("Y-m-d")) { // present
            $table .= '<tr style="background-color:white;font-weight:600;"><td>' . $bh["name"] . " " . $bh["surname"] . '</td><td>' . $bh["email"] . ', ' . $bh["telephone"] . '</td><td style="color:red;">' . (new DateTime($bh["date_from"]))->format("d.m.Y") . ' - ' . (new DateTime($bh["date_to"]))->format("d.m.Y") . '</td><td style="color:black;">' . (string)$bh["adults"] . ' + ' . (string)$bh["kids"] . '</td><td style="color:black;">' . (string)$bh["price"] . ' €</td><td style="color:red;">' . t("POBYT PRÁVE PREBIEHA") . '</td></tr>';
        } else { // future
            $table .= '<tr style="background-color:#404040;font-weight:600;"><td>' . $bh["name"] . " " . $bh["surname"] . '</td><td>' . $bh["email"] . ', ' . $bh["telephone"] . '</td><td>' . (new DateTime($bh["date_from"]))->format("d.m.Y") . ' - ' . (new DateTime($bh["date_to"]))->format("d.m.Y") . '</td><td>' . (string)$bh["adults"] . ' + ' . (string)$bh["kids"] . '</td><td>' . (string)$bh["price"] . ' €</td><td><form method="post" action=""><details><summary onclick="alert(\'' . t("Nezabudnite, že je Vašou povinnosťou informvať zákazníka a vrátiť mu všetky zaplatené poplatky.") . '\')" style="text-decoration:underline;cursor: pointer;">' . t("STORNO REZERVÁCIE") . '</summary><p><button type="submit" style="text-decoration:underline;cursor: pointer;" class="bookings-input" name="cancel" value="' . (string)$bh["bookings_id"] . '">' . t("POTVRDIŤ") . '</button></p></details></form></td></tr>';
        };
    }
    echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var partnersite = document.querySelector("#partnersite");
                if (partnersite) {
                    partnersite.innerHTML = `<table class="bookings-table"><tr><th>' . t("Meno") . '</th><th>' . t("Kontakt") . '</th><th>Dátum</th><th><abbr title="' . t("dospelí + deti") . '">' . t("Počet osôb") . '</abbr></th><th>' . t("Cena") . '</th><th></th></tr>' . $table . '</table>`;
                }
            });
        </script>';
}

if (isset($_POST['cancel'])) {
    $cancel_id = $_POST['cancel'];
    $sql_cancel = "DELETE FROM bookings WHERE bookings_id = '" . $cancel_id . "'";
    $conn->query($sql_cancel);
    echo "<script>
            document.addEventListener('DOMContentLoaded', () => {
                var partnersite = document.querySelector('#partnersite');
                partnersite.innerHTML = `<div style='font-size:2.5vh;text-align:center;color:green;padding-top:4vh;'><b>Rezervácia bola úspešne zrušená.</b></div>`;
            });
          </script>";
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
    <head>
        <meta charset="UTF-8">
        <title><?php echo t("Pre partnerov") . " | " . t("accomio | Hotely, penzióny a omnoho viac");?></title>
        <link rel="icon" type="image/x-icon" href="styles/icons/icon.ico">
        <link rel='stylesheet' href='styles/basic.css'>
        <link rel='stylesheet' href='styles/user.css'>
        <link rel='stylesheet' href='styles/hotels.css'>
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
        
        <form method="get" class="navbar">
            <button class="navbtn" type="submit" name="site" value="res" <?php if($site === "res") {echo "style='background-color:#27f695;'";} ?>><?php echo t("Rezervácie");?></button>
            <button class="navbtn" type="submit" name="site" value="rev" <?php if($site === "rev") {echo "style='background-color:#27f695;'";} ?>><?php echo t("Recenzie");?></button>
        </form>

        <div id="partnersite"></div>

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