<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "accomio";

$conn = new mysqli($servername, $username, $password, $dbname);

$servername = "localhost";

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
    $sql_login = "SELECT * FROM customers WHERE code = '" . $_SESSION["cd"] . "' AND log = '" . $_SESSION["lg"] . "'";
    $s_login = $conn->query($sql_login);
    if ($s_login->num_rows == 0) {
        session_destroy();
    };
};

if (!isset($_GET['sort'])) {
    $_GET['sort'] = "price ASC";
};

$sql = "SELECT * FROM hotels_info ORDER BY " . $_GET['sort'];
$selected = $conn->query($sql);
$listnum = 0;
$htlslst = '';
while($result = $selected->fetch_assoc()) {
    $sql_rooms = "SELECT * FROM hotels_rooms WHERE hotels_id = '" . $result['hotels_id'] . "' ORDER BY room_price ASC LIMIT 1";
    $s_rooms = $conn->query($sql_rooms);
    $htl_price = $s_rooms->fetch_assoc()["room_price"];
    
    $sql_review = "SELECT * FROM hotels_reviews WHERE hotels_id = '" . $result['hotels_id'] . "'";
    $s_review = $conn->query($sql_review);
    $a = 0;
    $b = 0;
    if ($s_review->num_rows == 0) {
        $htl_rating = 0;
    } else {
        while ($review = $s_review->fetch_assoc()) {
            $a += $review["rating"];
            $b += 1;
        };
        $htl_rating = round($a / $b, 1);
    };

    if ($listnum != 3) {
        $listnum += 1;
    } else {
        $listnum = 1;
    }
    $htlslst = $htlslst . '{
        name: "' . t($result['name']) . '",
        location: "' . t($result['location']) . '",
        country: "' . t($result['country']) . '",
        price: ' . $htl_price . ',
        rating: ' . $htl_rating . ',
        list_num:' . $listnum . ',
        url: "' . $result['url'] . '"
    },';
    };
echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
            var htlslst = document.querySelector("#hotelslist")
            if (htlslst) {
                var hotels = [' . rtrim($htlslst, ",") . ']
                hotels.forEach(hotel => {
                    var hotelDiv = document.createElement("div")
                    hotelDiv.className = `hotellist-c${hotel.list_num}`
                    hotelDiv.onclick = function () {document.location.href = `${hotel.url}`}
                    hotelDiv.innerHTML = `<img src="styles/hotels/${hotel.url}.png" class="hotellist-img"><span class="hotellist-name">${hotel.name}</span><abbr style="text-decoration:none" title="${hotel.country}"><span class="hotellist-location">${hotel.location}</span></abbr><span class="hotellist-price">${hotel.price}€</span><span class="hotellist-rating">${hotel.rating}★</span>`
                    htlslst.appendChild(hotelDiv)
                })
            } 
            })
        </script>';
?>
<!DOCTYPE html>
<!--
to-dos:
- langs
- cities in placelist
-->
<html lang="<?php echo $lang; ?>">
    <head>
        <meta charset="UTF-8">
        <title><?php echo t("accomio | Hotely, penzióny a omnoho viac");?></title>
        <link rel="icon" type="image/x-icon" href="styles/icons/icon.ico">
        <link rel='stylesheet' href='styles/basic.css'>
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

        <div id="search" style="color:white;">
            <div class="welcometext"><?php echo t("Kam to dnes bude?");?></div>
            <form id="searchform" method="get" action="search">
                <div id="placediv" class="formdiv">
                <label for="place"><?php echo t("Kam cestujete?");?></label><br>
                <input list="placelist" class="searchinput" id="place" name="place" placeholder="" style="width: 15vw;" required>
                    <datalist id="placelist">
                        <div id="placelistdiv" class="formdiv">
                            <?php
                                $sql_places = "SELECT * FROM hotels_info ORDER BY location ASC";
                                $s_places = $conn->query($sql_places);
                                if ($s_places->num_rows > 0) {
                                    while ($place = $s_places->fetch_assoc()) {
                                        echo '<option value="' . t($place['location']) . '">';
                                    }
                                }
                            ?>
                        </div>
                    </datalist>
                </div>
                <div id="datefromdiv" class="formdiv">
                    <label for="datefrom"><?php echo t("Príchod");?></label><br>
                    <input type="date" class="searchinput" id="datefrom" name="datefrom" oninput="dateto.min = this.value" min="<?php echo date("Y-m-d"); ?>" required>
                </div>
                <div id="datetodiv" class="formdiv">
                    <label for="dateto"><?php echo t("Odchod");?></label><br>
                    <input type="date" class="searchinput" id="dateto" name="dateto" oninput="datefrom.max = this.value" min="<?php echo date("Y-m-d"); ?>" required>
                </div>
                <div id="adultsdiv" class="formdiv">
                    <label for="adults"><?php echo t("Počet dospelých");?></label><br>
                    <input type="number" class="searchinput" id="adults" name="adults" value="1" min="1" max="20" style="width: 6.5vw; text-align: center;" required>
                </div>
                <div id="kidsdiv" class="formdiv">
                    <label for="kids"><?php echo t("Počet detí");?></label><br>
                    <input type="number" class="searchinput" id="kids" name="kids" value="0" min="0" max="10" style="width: 6.5vw; text-align: center;" required>
                </div>
                <input type="hidden" id="sort" name="sort" value="price ASC">
                <div id="submitdiv" class="formdiv">
                    <label></label><br>
                    <input type="image" src="styles/icons/search_white.svg" id="submitimage" onmouseover="document.querySelector('#submitimage').src='styles/icons/search_black.svg'" onmouseout="document.querySelector('#submitimage').src='styles/icons/search_white.svg'">
                </div>
            </form>
        </div>

        <form id="sortform" method="get" action="" onsubmit="location.reload()">
            <div id="sortdiv" class="formdiv">
                <label for="sort" class="sortlabel" style="top: 62vh;"><?php echo t("Zoradiť");?>:</label><br>
                <select class="sortinput" id="sort" name="sort" onchange="document.querySelector('#sortform').submit()" style="top: 62vh;">
                    <option value="price ASC" <?php if ($_GET['sort'] == "price ASC") {echo "selected";} ?>><?php echo t("Najnižšia cena");?></option>
                    <option value="price DESC" <?php if ($_GET['sort'] == "price DESC") {echo "selected";} ?>><?php echo t("Najvyššia cena");?></option>
                    <option value="rating DESC" <?php if ($_GET['sort'] == "rating DESC") {echo "selected";} ?>><?php echo t("Najlepšie hodnotenie");?></option>
                </select>
            </div>
        </form>

        <div id="hotelslist"></div>

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