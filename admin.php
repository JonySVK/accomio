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
    } elseif ($login["nationality"] != "admin") {
        header("Location: /accomio");
        exit();
    };
}  else {
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

if (isset($_GET["site"]) && $_GET["site"] == "com") {
    $site = "com";
    $sql_com = "SELECT * FROM contact WHERE `read` = 0 ORDER BY date DESC"; $s_com = $conn->query($sql_com);
    $cont = "";
    while($com = $s_com->fetch_assoc()) {
        $cont .= "<div class='comdiv'><div class='comname'>" . (string)$com["name"] . "</div><div class='comdate'>" . ((new DateTime($com["date"]))->format("d.m.Y H:i:s")) . "</div><div class='commessage'><i>" . (string)$com["message"] . "</i></div><div class='comemail'>" . t("Odpovedajte na:") . " " . (string)$com["email"] . "</div><form action='' method='post'><input type='hidden' name='read' value='" . (string)$com["id"] . "'><input type='submit' value='" . t("OZNAČIŤ AKO PREČÍTANÉ") . "' class='combtn'></form></div>";
    }
    echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var adminsite = document.querySelector("#adminsite");
                if (adminsite) {
                    adminsite.innerHTML = `<div class="text-title">' . t("Správy od zákazníkov") . '</div>' . $cont . '`
                }
            });
            </script>';
} elseif (isset($_GET["site"]) && $_GET["site"] == "use") {
    $site = "use";
    echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var adminsite = document.querySelector("#adminsite");
                if (adminsite) {
                    adminsite.innerHTML = `<form method="post" action="" style="text-align: center;">
            <input type="email" name="email" placeholder="' . t("Email") . '" class="contactinput" required><br>
            <input type="submit" value="' . t("Vyhľadať") . '" class="contactinput" style="margin-top: -1vh;">
        </form>`
                }
            });
            </script>';
} else {
    $site = "com";
    $sql_com = "SELECT * FROM contact WHERE `read` = 0 ORDER BY date DESC"; $s_com = $conn->query($sql_com);
    $cont = "";
    while($com = $s_com->fetch_assoc()) {
        $cont .= "<div class='comdiv'><div class='comname'>" . (string)$com["name"] . "</div><div class='comdate'>" . ((new DateTime($com["date"]))->format("d.m.Y H:i:s")) . "</div><div class='commessage'><i>" . (string)$com["message"] . "</i></div><div class='comemail'>" . t("Odpovedajte na:") . " " . (string)$com["email"] . "</div><form action='' method='post'><input type='hidden' name='read' value='" . (string)$com["id"] . "'><input type='submit' value='" . t("OZNAČIŤ AKO PREČÍTANÉ") . "' class='combtn'></form></div>";
    }
    echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var adminsite = document.querySelector("#adminsite");
                if (adminsite) {
                    adminsite.innerHTML = `<div class="text-title">' . t("Správy od zákazníkov") . '</div>' . $cont . '`
                }
            });
            </script>';
}

if(isset($_POST['read'])) {
    $sql_read = "UPDATE contact SET `read` = 1 WHERE id = '" . $_POST['read'] . "'";
    $conn->query($sql_read);
}

if(isset($_POST['email'])) {
    $email = $_POST['email'];
    $sql_user = "SELECT * FROM customers WHERE email = '" . $email . "'";
    $s_user = $conn->query($sql_user);
    if ($s_user->num_rows > 0) {
        $output = $s_user->fetch_assoc();
        if ($output["nationality"] == "admin") {
            $role = "<div style='color: red; font-weight: bold;'>" . t("Tento používateľ je administrátor.") . "</div>";
        } elseif ($output["nationality"] == "partner") {
            $sql_hotel = "SELECT * FROM hotels_info WHERE hotels_id = '" . $output["surname"] . "'";
            $s_hotel = $conn->query($sql_hotel);
            $hotel = $s_hotel->fetch_assoc();
            $role = "<div style='color: orange; font-weight: bold;'>" . t("Tento používateľ je partner z hotela") . " " . t($hotel["name"]) . ".</div>";
        } else {
             $role = "<div style='color: green; font-weight: bold;'>" . t("Tento používateľ je bežný používateľ.") . "</div>";
        }
        echo '<script>
                document.addEventListener("DOMContentLoaded", () => {
                    var adminsite = document.querySelector("#adminsite");
                    adminsite.innerHTML = `<form method="post" action="" style="text-align: center;">
            <input type="email" name="email" placeholder="Email" class="contactinput" required><br>
            <input type="submit" value="Vyhľadať" class="contactinput" style="margin-top: -1vh;">
        </form><br><br><br><div class="useroutput">' . t("Meno") . ': ' . $output["name"] . ' ' . $output["surname"] . '<br>
            ' . t("Email") . ': ' . $output["email"] . '<br>
            ' . t("Telefón") . ': ' . $output["telephone"] . '<br>
            ' . t("Adresa") . ': ' . $output["address"] . '<br>
            ' . t("Národnosť") . ': ' . $output["nationality"] . '<br><br>' . $role . '</div><br><br>

            <form method="post" action="" style="text-align: center;">
                <input type="hidden" name="id" value="' . $output["customers_id"] . '">
                <button type="submit" name="action" value="password" id="contactsubmit" style="font-size:2vh; width: 20vw; height: 8vh;margin: 1vh;">' . t("ZMENIŤ POUŽÍVATEĽOVI HESLO") . '</button><br>
                <button type="submit" name="action" value="normal" id="contactsubmit" style="font-size:2vh; width: 20vw; height: 8vh;margin: 1vh;">' . t("ZMENIŤ NA BEŽNÉHO POUŽÍVATEĽA") . '</button><br>
                <button type="submit" name="action" value="partner" id="contactsubmit" style="font-size:2vh; width: 20vw; height: 8vh;margin: 1vh;">' . t("ZMENIŤ NA PARTNERA") . '</button><br>
                <button type="submit" name="action" value="admin" id="contactsubmit" style="font-size:2vh; width: 20vw; height: 8vh;margin: 1vh;">' . t("ZMENIŤ NA ADMINISTRÁTORA") . '</button><br>
                <button type="submit" name="action" value="delete" id="contactsubmit" style="font-size:2vh; width: 20vw; height: 8vh;margin: 1vh;">' . t("ZMAZAŤ POUŽÍVATEĽA") . '</button><br>
                <input type="checkbox" class="contactinput" style="margin-right: -9vw; margin-left: -10vw; margin-top: 2vh;" required> ' . t("Som si istý, že chcem danú akciu vykonať.") . '
            </form>`;
                });
              </script>';
    } else {
        echo '<script>
                document.addEventListener("DOMContentLoaded", () => {
                    var adminsite = document.querySelector("#adminsite");
                    adminsite.innerHTML = `<form method="post" action="" style="text-align: center;">
            <input type="email" name="email" placeholder="' . t("Email") . '" class="contactinput" required><br>
            <input type="submit" value="' . t("Vyhľadať") . '" class="contactinput" style="margin-top: -1vh;">
        </form><div style="font-size:2.5vh;text-align:center;color:red;"><b>' . t("Hľadaný email nie je v databáze.") . '</b></div>`;
                });
              </script>';
    }
}

if (isset($_POST['action'])) {
    $id = $_POST['id'];
    if ($_POST['action'] == "password") {
        $new_password = bin2hex(random_bytes(5));
        $sql_hotel = "UPDATE customers SET password = '" . password_hash($new_password, PASSWORD_DEFAULT) . "' WHERE customers_id = '" . $id . "'";
        $conn->query($sql_hotel);
        echo "<script>
                document.addEventListener('DOMContentLoaded', () => {
                    var adminsite = document.querySelector('#adminsite');
                    adminsite.innerHTML = `<div style='font-size:2.5vh;text-align:center;color:green;padding-top:4vh;'><b>" . t("Používateľovo heslo bolo zmenené. Nezabudnite informovať používateľa o novom hesle. Nové heslo:") . " <span style='color: red; font-weight: 800;'>" . $new_password . "</span></b></div>`;
                });
              </script>";
    } elseif ($_POST['action'] == "normal") {
        $sql_action = "UPDATE customers SET nationality = 'undefined' WHERE customers_id = '" . $id . "'";
        $conn->query($sql_action);
        echo "<script>
                document.addEventListener('DOMContentLoaded', () => {
                    var adminsite = document.querySelector('#adminsite');
                    adminsite.innerHTML = `<div style='font-size:2.5vh;text-align:center;color:green;padding-top:4vh;'><b>" . t("Používateľ bol zmenený na bežného používateľa.") . "</b></div>`;
                });
              </script>";
    } elseif ($_POST['action'] == "partner") {
        echo "<script>
                document.addEventListener('DOMContentLoaded', () => {
                    var adminsite = document.querySelector('#adminsite');
                    adminsite.innerHTML = `<div style='font-size:2.5vh;text-align:center;color:white;padding-top:4vh;'><form method='post' action='' style='text-align: center;'><input type='hidden' name='id' value='" . $id . "'><input type='number' name='hotel' placeholder='" . t("ID hotela") . "' class='contactinput' required><br><input type='submit' value='" . t("Potvrdiť") . "' class='contactinput' style='margin-top: -1vh;'></form></div>`;
                });
              </script>";
    } elseif ($_POST['action'] == "admin") {
        $sql_action = "UPDATE customers SET nationality = 'admin' WHERE customers_id = '" . $id . "'";
        $conn->query($sql_action);
        echo "<script>
                document.addEventListener('DOMContentLoaded', () => {
                    var adminsite = document.querySelector('#adminsite');
                    adminsite.innerHTML = `<div style='font-size:2.5vh;text-align:center;color:green;padding-top:4vh;'><b>" . t("Používateľ bol zmenený na administrátora.") . "</b></div>`;
                });
              </script>";
    } elseif ($_POST['action'] == "delete") {
        $sql_action = "DELETE FROM customers WHERE customers_id = '" . $id . "'";
        $conn->query($sql_action);
        echo "<script>
                document.addEventListener('DOMContentLoaded', () => {
                    var adminsite = document.querySelector('#adminsite');
                    adminsite.innerHTML = `<div style='font-size:2.5vh;text-align:center;color:green;padding-top:4vh;'><b>" . t("Používateľ bol úspešne odstránený.") . "</b></div>`;
                });
              </script>";
    }
}
    
if (isset($_POST['hotel'])) {
    $sql_ht = "SELECT * FROM customers WHERE customers_id = '" . $_POST['id'] . "'";
    $s_ht = $conn->query($sql_ht);
    $ht = $s_ht->fetch_assoc();
    $sql_hotel = "UPDATE customers SET name = '" . $ht['name'] . " " . $ht['surname'] . "', surname = '" . $_POST['hotel'] . "', nationality = 'partner' WHERE customers_id = '" . $_POST['id'] . "'";
    $conn->query($sql_hotel);
    echo "<script>
                document.addEventListener('DOMContentLoaded', () => {
                    var adminsite = document.querySelector('#adminsite');
                    adminsite.innerHTML = `<div style='font-size:2.5vh;text-align:center;color:green;padding-top:4vh;'><b>" . t("Používateľ bol zmenený na partnera.") . "</b></div>`;
                });
              </script>";
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
    <head>
        <meta charset="UTF-8">
        <title>Admin | <?php echo t("accomio | Hotely, penzióny a omnoho viac");?></title>
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
            <button class="navbtn" type="submit" name="site" value="com" <?php if($site === "com") {echo "style='background-color:#27f695;'";} ?>><?php echo t("Komunikácia");?></button>
            <button class="navbtn" type="submit" name="site" value="use" <?php if($site === "use") {echo "style='background-color:#27f695;'";} ?>><?php echo t("Použivatelia");?></button>
        </form>

        <div id="adminsite"></div>

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