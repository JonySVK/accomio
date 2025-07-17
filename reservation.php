<!-- pri preklade treba priadat aj SK verziu a upravit nazvy statov a narodnosti -->
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
    $user = $s_login->fetch_assoc();
};

parse_str(explode('?', $_SERVER['REQUEST_URI'])[1], $get);

if (isset($get['lang'])) {
    $lang = $get['lang'];
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

if (isset($get["hotel"]) && isset($get["room"]) && isset($get["datefrom"]) && isset($get["dateto"]) && isset($get["adults"]) && isset($get["kids"])) {
    $sql_htl = "SELECT * FROM hotels_info WHERE hotels_id = '" . $get['hotel'] . "'";
    $s_htl = $conn->query($sql_htl);
    $htl = $s_htl->fetch_assoc();


    $sql_rooms = "SELECT * FROM hotels_rooms WHERE rooms_id = '" . $get['room'] . "'";
    $s_rooms = $conn->query($sql_rooms);
    $room = $s_rooms->fetch_assoc();

    $sql_ht = "SELECT * FROM hotels_info WHERE hotels_id = '" . $room['hotels_id'] . "'";
    $s_ht = $conn->query($sql_ht);
    $ht = $s_ht->fetch_assoc();

    $date_from = new DateTime($get['datefrom']);
    $date_to = new DateTime($get['dateto']);
    $nights = $date_from->diff($date_to)->days;

    $htl_price = ($room['room_price'] * $get['adults'] * $nights) + ($room['room_price'] * $get['kids'] * $ht['kids_price'] * $nights);

    if (isset($_SESSION["cd"])) {
        $first = strpos($user["address"], ',');
        $second = strpos($user["address"], ',', $first + 1);
        $address = trim(substr($user["address"], 0, $first));
        $city = trim(substr($user["address"], $first + 1, $second - $first - 1));
        $country = trim(substr($user["address"], $second + 1));
    };

    if (isset($_POST["next1"])) { // 2 personal data
        echo '<script>
                document.addEventListener("DOMContentLoaded", () => {
                    var c = document.querySelector(".content");
                    if (c) {
                        c.innerHTML = `<div class="res-div">
                <div class="recap-title">' . t("Rekapitulácia Vašej rezervácie:") . '</div><br>
                <div class="recap-text">
                    <b>' . t("Hotel:") . '</b> ' . t($htl["name"]) . '<br>
                    <b>' . t("Dátum:") . '</b> ' . (new DateTime($get["datefrom"]))->format("d.m.Y") . " - " . (new DateTime($get["dateto"]))->format("d.m.Y") . '<br>
                    <b>' . t("Počet osôb:") . '</b> ' . $get["adults"] . " + " . $get["kids"] . '<br>
                    <b>' . t("Typ izby:") . '</b> ' . t($room["room_name"]) . '<br>
                    <b>' . t("Celková cena:") . '</b> ' . $htl_price . ' €<br><br>
                    <i>' . t("V prípade, ak chcete niečo vo Vašej rezervácií zmeniť, vráťte sa do vyhľadávania a vytvorte rezerváciu nanovo.") . '</i><br><br>
                </div>
                </div>
                
                        <div class="res-div, form">
            <form method="post" action="" id="nextform2">
                <label for="name">' . t("Vaše meno:") . '</label><br>
                <input type="text" id="name" name="name" class="datainput" ' . (isset($_SESSION["cd"]) ? "value= '" . $user["name"] . "'" : "") . ' required><br>
                <label for="surname">' . t("Vaše priezvisko:") . '</label><br>
                <input type="text" id="surname" name="surname" class="datainput" ' . (isset($_SESSION["cd"]) ? "value= '" . $user["surname"] . "'" : "") . ' required><br>
                <label for="email">' . t("Váš email:") . '</label><br>
                <input type="email" id="email" name="email" class="datainput" ' . (isset($_SESSION["cd"]) ? "value= '" . $user["email"] . "'" : "") . ' required><br>
                <label for="phone">' . t("Vaše telefónne číslo:") . '</label><br>
                <select id="callingcode" name="callingcode" class="datainput" style="margin: 2vh 0vw 2vh 1vw;width:5vw;" required><option value="" disabled></option><option value="+420" ' . (isset($_SESSION["cd"]) && substr($user["telephone"], 0, -9) === "+420" ? "selected" : "") . ' >+420</option><option value="+421" ' . (isset($_SESSION["cd"]) && substr($user["telephone"], 0, -9) === "+421" ? "selected" : "") . ' >+421</option>' /* */ . '</select>
                <input type="number" id="telephone" name="telephone" class="datainput" ' . (isset($_SESSION["cd"]) ? "value= '" . substr($user["telephone"], -9) . "'" : "") . ' style="margin: 2vh 1vw 2vh 0vw;width:15vw;" maxlength="9" minlength="9" required><br>
                <label for="address">' . t("Vaša adresa:") . '</label><br>
                <input type="text" id="address" name="address" class="datainput" ' . (isset($_SESSION["cd"]) ? "value= '" . $address . "'" : "") . ' required><br>
                <label for="city">' . t("Vaše mesto:") . '</label><br>
                <input type="text" id="city" name="city" class="datainput" ' . (isset($_SESSION["cd"]) ? "value= '" . $city . "'" : "") . ' required><br>
                <label for="country">' . t("Váš štát:") . '</label><br>
                <select id="country" name="country" class="datainput" required><option value="" disabled></option><option value="Czech republic" ' . (isset($_SESSION["cd"]) && $country === "Czech republic" ? "selected" : "") . ' >' . t("Česká republika") . '</option><option value="Slovakia" ' . (isset($_SESSION["cd"]) && $country === "Slovakia" ? "selected" : "") . ' >' . t("Slovenská republika") . '</option>' /* */ . '</select><br>
                <label for="nationality">' . t("Vaša národnosť:") . '</label><br>
                <select id="nationality" name="nationality" class="datainput" required><option value="" disabled></option><option value="Czech" ' . (isset($_SESSION["cd"]) && $user["nationality"] === "Czech" ? "selected" : "") . ' >' . t("Česká") . '</option><option value="Slovak" ' . (isset($_SESSION["cd"]) && $user["nationality"] === "Slovak" ? "selected" : "") . ' >' . t("Slovenská") . '</option>' /* */ . '</select><br>
                <input type="hidden" name="user"' . (isset($_SESSION["cd"]) ? "value= '" . $user["customers_id"] . "'" : "0") . '">
                <input type="submit" class="nextbtn" name="next2" value="' . t("Potvrdiť a pokračovať") . '">
            </form>
            </div>`
                    }
                });
            </script>';
    } elseif (isset($_POST["next2"])) { // 3 recap data
        echo '<script>
                document.addEventListener("DOMContentLoaded", () => {
                    var c = document.querySelector(".content");
                    if (c) {
                        c.innerHTML = `<div class="res-div">
                <div class="recap-title">' . t("Rekapitulácia Vašej rezervácie:") . '</div><br>
                <div class="recap-text">
                    <b>' . t("Hotel:") . '</b> ' . t($htl["name"]) . '<br>
                    <b>' . t("Dátum:") . '</b> ' . (new DateTime($get["datefrom"]))->format("d.m.Y") . " - " . (new DateTime($get["dateto"]))->format("d.m.Y") . '<br>
                    <b>' . t("Počet osôb:") . '</b> ' . $get["adults"] . " + " . $get["kids"] . '<br>
                    <b>' . t("Typ izby:") . '</b> ' . t($room["room_name"]) . '<br>
                    <b>' . t("Celková cena:") . '</b> ' . $htl_price . ' €<br><br>
                    <i>' . t("V prípade, ak chcete niečo vo Vašej rezervácií zmeniť, vráťte sa do vyhľadávania a vytvorte rezerváciu nanovo.") . '</i><br><br>
                </div>
                </div>
                
                        <div class="res-div">
            <div class="recap-title">' . t("Rekapitulácia Vašich údajov:") . '</div><br>
            <div class="recap-text">
                <b>' . t("Vaše meno:") . '</b> ' . $_POST["name"] . '<br>
                <b>' . t("Vaše priezvisko:") . '</b> ' . $_POST["surname"] . '<br>
                <b>' . t("Váš email:") . '</b> ' . $_POST["email"] . '<br>
                <b>' . t("Vaše telefónne číslo:") . '</b> ' . $_POST["callingcode"] . $_POST["telephone"] . '<br>
                <b>' . t("Vaša adresa:") . '</b> ' . $_POST["address"] . '<br>
                <b>' . t("Vaše mesto:") . '</b> ' . t($_POST["city"]) . '<br>
                <b>' . t("Váš štát:") . '</b> ' . t($_POST["country"]) . '<br>
                <b>' . t("Vaša národnosť:") . '</b> ' . t($_POST["nationality"]) . '
            </div>
            <form method="post" action="" id="nextform3">
                <input type="hidden" name="name" value="' . $_POST["name"] . '">
                <input type="hidden" name="surname" value="' . $_POST["surname"] . '">
                <input type="hidden" name="email" value="' . $_POST["email"] . '">
                <input type="hidden" name="callingcode" value="' . $_POST["callingcode"] . '">
                <input type="hidden" name="telephone" value="' . $_POST["callingcode"] . $_POST["telephone"] . '">
                <input type="hidden" name="address" value="' . $_POST["address"] . '">
                <input type="hidden" name="city" value="' . $_POST["city"] . '">
                <input type="hidden" name="country" value="' . $_POST["country"] . '">
                <input type="hidden" name="nationality" value="' . $_POST["nationality"] . '">
                <input type="hidden" name="user" value="' . $_POST["user"] . '">
                <input type="submit" class="nextbtn" name="next3" value="' . t("Potvrdiť a pokračovať") . '">
                <input type="submit" class="nextbtn" name="next1" value="' . t("Zmeniť údaje") . '">
            </form>
        </div>`
                    }
                });
            </script>';
    } elseif (isset($_POST["next3"])) { // 4 payment
echo '<script>
                document.addEventListener("DOMContentLoaded", () => {
                    var c = document.querySelector(".content");
                    if (c) {
                        c.innerHTML = `<div class="res-div">
                <div class="recap-title">' . t("Rekapitulácia Vašej rezervácie:") . '</div><br>
                <div class="recap-text">
                    <b>' . t("Hotel:") . '</b> ' . t($htl["name"]) . '<br>
                    <b>' . t("Dátum:") . '</b> ' . (new DateTime($get["datefrom"]))->format("d.m.Y") . " - " . (new DateTime($get["dateto"]))->format("d.m.Y") . '<br>
                    <b>' . t("Počet osôb:") . '</b> ' . $get["adults"] . " + " . $get["kids"] . '<br>
                    <b>' . t("Typ izby:") . '</b> ' . t($room["room_name"]) . '<br>
                    <b>' . t("Celková cena:") . '</b> ' . $htl_price . ' €<br><br>
                    <i>' . t("V prípade, ak chcete niečo vo Vašej rezervácií zmeniť, vráťte sa do vyhľadávania a vytvorte rezerváciu nanovo.") . '</i><br><br>
                </div>
                </div>
                
                        <div class="res-div">
            <div class="recap-title">' . t("Rekapitulácia Vašich údajov:") . '</div><br>
            <div class="recap-text">
                <b>' . t("Vaše meno:") . '</b> ' . $_POST["name"] . '<br>
                <b>' . t("Vaše priezvisko:") . '</b> ' . $_POST["surname"] . '<br>
                <b>' . t("Váš email:") . '</b> ' . $_POST["email"] . '<br>
                <b>' . t("Vaše telefónne číslo:") . '</b> ' . $_POST["callingcode"] . $_POST["telephone"] . '<br>
                <b>' . t("Vaša adresa:") . '</b> ' . $_POST["address"] . '<br>
                <b>' . t("Vaše mesto:") . '</b> ' . t($_POST["city"]) . '<br>
                <b>' . t("Váš štát:") . '</b> ' . t($_POST["country"]) . '<br>
                <b>' . t("Vaša národnosť:") . '</b> ' . t($_POST["nationality"]) . '
            </div>
        </div>
        
                <div class="res-div">
            <form method="post" action="" id="nextform4">
                <input type="hidden" name="name" value="' . $_POST["name"] . '">
                <input type="hidden" name="surname" value="' . $_POST["surname"] . '">
                <input type="hidden" name="email" value="' . $_POST["email"] . '">
                <input type="hidden" name="callingcode" value="' . $_POST["callingcode"] . '">
                <input type="hidden" name="telephone" value="' . $_POST["telephone"] . '">
                <input type="hidden" name="address" value="' . $_POST["address"] . '">
                <input type="hidden" name="city" value="' . $_POST["city"] . '">
                <input type="hidden" name="country" value="' . $_POST["country"] . '">
                <input type="hidden" name="nationality" value="' . $_POST["nationality"] . '">
                <input type="hidden" name="user" value="' . $_POST["user"] . '">
                <label for="payment" style="margin: 0;"><abbr title="' . t("Momentálne žiaľ poskytujeme len možnosť platby priamo v hoteli. Platba cez internet nie je možná.") . '">' . t("Vyberte spôsob platby:") . '</abbr></label>
                <select id="payment" name="payment" class="datainput" required><option value="In hotel" selected>' . t("Platba v hoteli") . '</option></select><br>
                <input type="checkbox" style="height:20px;width:20px;" required> ' . t("Zadaním rezervácie sa zaväzujem zaplatiť požadovanú sumu alebo storno poplatok ubytovateľovi.") . '<br>
                <input type="checkbox" style="height:20px;width:20px;" required> ' . t("Súhlasím s ") . " <a href='terms'>" . t("Všeobecnými podmienkami") . '</a>.<br>
                <input type="checkbox" style="height:20px;width:20px;" required> ' . t("Súhlasím so spracovaním mojich osobných údajov podľa ") . " <a href='privacy'>" . t("Zásad spracovania osobných údajov") . '</a>.<br>
                <input type="submit" class="nextbtn" name="next4" value="' . t("Záväzne zarezervovať") . '">
            </form>
        </div>`
                    }
                });
            </script>';
    } elseif (isset($_POST["next4"])) { // 5 send
        $sql_r = "INSERT INTO `bookings` (`bookings_id`, `customers_id`, `hotels_id`, `rooms_id`, `adults`, `kids`, `name`, `surname`, `email`, `telephone`, `address`, `nationality`, `date_from`, `date_to`, `price`, `payment`) VALUES (NULL, '" . (int)$_POST["user"] . "', '" . (int)$get['hotel'] . "', '" . (int)$get['room'] . "', '" . (int)$get['adults'] . "', '" . (int)$get['kids'] . "', '" . $conn->real_escape_string($_POST["name"]) . "', '" . $conn->real_escape_string($_POST["surname"]) . "', '" . $conn->real_escape_string($_POST["email"]) . "', '" . $conn->real_escape_string($_POST["telephone"]) . "', '" . $conn->real_escape_string($_POST["address"] . ", " . $_POST["city"] . ", " . $_POST["country"]) . "', '" . $conn->real_escape_string($_POST["nationality"]) . "', '" . $get["datefrom"] . "', '" . $get["dateto"] . "', '" . (int)$htl_price . "', '" . $conn->real_escape_string($_POST["payment"]) . "')";
        $conn->query($sql_r);
        if ($conn->affected_rows > 0) { // 5 success
            $sql_booking = "SELECT bookings_id FROM bookings WHERE customers_id = '" . $_POST["user"] . "' AND date_from = '" . $get["datefrom"] . "' AND date_to = '" . $get["dateto"] . "' AND price = '" . $htl_price . "'";
            $s_booking = $conn->query($sql_booking);
            $booking = $s_booking->fetch_assoc();
        echo '<script>
                document.addEventListener("DOMContentLoaded", () => {
                    var c = document.querySelector(".content");
                    if (c) {
                        c.innerHTML = `<div class="res-div">
                <div class="recap-title" style="font-weight:700;">' . t("Vaša rezervácia bola zaslaná.") . '</div>
                <div class="recap-text">' . t("Číslo rezervácie:") . ' ' . $booking["bookings_id"] .'</div><br><br>

                <div class="recap-title">' . t("Rekapitulácia Vašej rezervácie:") . '</div><br>
                <div class="recap-text">
                    <b>' . t("Hotel:") . '</b> ' . t($htl["name"]) . '<br>
                    <b>' . t("Dátum:") . '</b> ' . (new DateTime($get["datefrom"]))->format("d.m.Y") . " - " . (new DateTime($get["dateto"]))->format("d.m.Y") . '<br>
                    <b>' . t("Počet osôb:") . '</b> ' . $get["adults"] . " + " . $get["kids"] . '<br>
                    <b>' . t("Typ izby:") . '</b> ' . t($room["room_name"]) . '<br>
                    <b>' . t("Celková cena:") . '</b> ' . $htl_price . ' €<br><br>
                </div>
                </div>
                
                        <div class="res-div">
            <div class="recap-title">' . t("Rekapitulácia Vašich údajov:") . '</div><br>
            <div class="recap-text">
                <b>' . t("Vaše meno:") . '</b> ' . $_POST["name"] . '<br>
                <b>' . t("Vaše priezvisko:") . '</b> ' . $_POST["surname"] . '<br>
                <b>' . t("Váš email:") . '</b> ' . $_POST["email"] . '<br>
                <b>' . t("Vaše telefónne číslo:") . '</b> ' . $_POST["callingcode"] . $_POST["telephone"] . '<br>
                <b>' . t("Vaša adresa:") . '</b> ' . $_POST["address"] . '<br>
                <b>' . t("Vaše mesto:") . '</b> ' . t($_POST["city"]) . '<br>
                <b>' . t("Váš štát:") . '</b> ' . t($_POST["country"]) . '<br>
                <b>' . t("Vaša národnosť:") . '</b> ' . t($_POST["nationality"]) . '
            </div>
        </div>`
                    }
                });
            </script>';
        } else { // 5 error
    echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var c = document.querySelector(".content");
                if (c) {
                    c.innerHTML = `<img src="styles/icons/error.svg" style="width: 20vh; height: 20vh; position: absolute; top: 30vh; left: 50%; transform: translate(-50%, -50%);">
                                            <div class="welcometext" style="padding-top: 30vh;">' . t("Niečo sa pokazilo.") . '</div>
                                            <div style="color:white;text-align:center;font-family:"Roboto", sans-serif; font-weight: 400; font-style: normal;font-size: 3vh; padding-top: 2vh;">' . t("Skúste vytvoriť rezerváciu ešte raz.") . '</div>`
                }
            });
        </script>';
        }
    } else { // 1 recap reservation
        echo '<script>
                document.addEventListener("DOMContentLoaded", () => {
                    var c = document.querySelector(".content");
                    if (c) {
                        c.innerHTML = `<div class="res-div">
                <div class="recap-title">' . t("Rekapitulácia Vašej rezervácie:") . '</div><br>
                <div class="recap-text">
                    <b>' . t("Hotel:") . '</b> ' . t($htl["name"]) . '<br>
                    <b>' . t("Dátum:") . '</b> ' . (new DateTime($get["datefrom"]))->format("d.m.Y") . " - " . (new DateTime($get["dateto"]))->format("d.m.Y") . '<br>
                    <b>' . t("Počet osôb:") . '</b> ' . $get["adults"] . " + " . $get["kids"] . '<br>
                    <b>' . t("Typ izby:") . '</b> ' . t($room["room_name"]) . '<br>
                    <b>' . t("Celková cena:") . '</b> ' . $htl_price . ' €<br><br>
                    <i>' . t("V prípade, ak chcete niečo vo Vašej rezervácií zmeniť, vráťte sa do vyhľadávania a vytvorte rezerváciu nanovo.") . '</i><br><br>
                    <form method="post" action="" id="nextform1">
                        <input type="submit" class="nextbtn" name="next1" value="' . t("Potvrdiť a pokračovať") . '">
                    </form>
                </div>
                </div>`
                    }
                });
            </script>';
    }
} else { // error
    echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                var c = document.querySelector(".content");
                if (c) {
                    c.innerHTML = `<img src="styles/icons/error.svg" style="width: 20vh; height: 20vh; position: absolute; top: 30vh; left: 50%; transform: translate(-50%, -50%);">
                                            <div class="welcometext" style="padding-top: 30vh;">' . t("Nemáme údaje potrebné na vytvorenie rezervácie.") . '</div>
                                            <div style="color:white;text-align:center;font-family:"Roboto", sans-serif; font-weight: 400; font-style: normal;font-size: 3vh; padding-top: 2vh;">' . t("Vráťte sa prosím do vyhľadávania a zadajte údaje ešte raz.") . '</div>`
                }
            });
        </script>';
}
?>
<!DOCTYPE html>
<!--
to-dos:
- langs
-->
<html lang="<?php echo $lang; ?>">
    <head>
        <meta charset="UTF-8">
        <title><?php echo t("Rezervácia") . " | " . t("accomio | Hotely, penzióny a omnoho viac");?></title> <!---->
        <link rel="icon" type="image/x-icon" href="styles/icons/icon.ico">
        <link rel='stylesheet' href='styles/basic.css'>
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
        
        <div class="content"></div>

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