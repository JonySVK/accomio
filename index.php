<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "accomio";

$conn = new mysqli($servername, $username, $password, $dbname);

$servername = "localhost";
                            
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
        name: "' . $result['name'] . '",
        location: "' . $result['location'] . '",
        country: "' . $result['country'] . '",
        price: ' . $result['price'] . ',
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

$conn->close();
?>
<!DOCTYPE html>
<!--
to-dos:
- langs
- cities in placelist
-->
<html lang="sk"> <!-- after translation edit -->
    <head>
        <meta charset="UTF-8">
        <title>accomio | Hotely, penzióny a omnoho viac</title>
        <link rel="icon" type="image/x-icon" href="styles/icons/icon.ico">
        <link rel='stylesheet' href='styles/basic.css'>
        <script src='scripts/basic.js'></script>
    </head>
    <body>
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
        <div id="search" style="color:white;">
            <div class="welcometext">Kam to dnes bude?</div>
            <form id="searchform" method="get" action="search">
                <div id="placediv" class="formdiv">
                <label for="place">Kam cestujete?</label><br>
                <input list="placelist" class="searchinput" id="place" name="place" placeholder="" style="width: 15vw;" required>
                    <datalist id="placelist">
                        <div id="placelistdiv" class="formdiv">
                            <!-- delete after connect database and edit  -->    
                            <option value="Bratislava">
                            <option value="Viedeň">
                            <option value="Budapešť">
                            <option value="Berlín">
                            <option value="Londýn">
                            <!-- end -->
                        </div>
                    </datalist>
                </div>
                <div id="datefromdiv" class="formdiv">
                    <label for="datefrom">Príchod</label><br>
                    <input type="date" class="searchinput" id="datefrom" name="datefrom" oninput="dateto.min = this.value" min="<?php echo date("Y-m-d"); ?>" required>
                </div>
                <div id="datetodiv" class="formdiv">
                    <label for="dateto">Odchod</label><br>
                    <input type="date" class="searchinput" id="dateto" name="dateto" oninput="datefrom.max = this.value" min="<?php echo date("Y-m-d"); ?>" required>
                </div>
                <div id="adultsdiv" class="formdiv">
                    <label for="adults">Počet dospelých</label><br>
                    <input type="number" class="searchinput" id="adults" name="adults" value="1" min="1" max="20" style="width: 6.5vw; text-align: center;" required>
                </div>
                <div id="kidsdiv" class="formdiv">
                    <label for="kids">Počet detí</label><br>
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
                <label for="sort" class="sortlabel" style="top: 62vh;">Zoradiť:</label><br>
                <select class="sortinput" id="sort" name="sort" onchange="document.querySelector('#sortform').submit()" style="top: 62vh;">
                    <option value="price ASC" <?php if ($_GET['sort'] == "price ASC") {echo "selected";} ?>>Najnižšia cena</option>
                    <option value="price DESC" <?php if ($_GET['sort'] == "price DESC") {echo "selected";} ?>>Najvyššia cena</option>
                    <option value="rating DESC" <?php if ($_GET['sort'] == "rating DESC") {echo "selected";} ?>>Najlepšie hodnotenie</option>
                </select>
            </div>
        </form>

        <div id="hotelslist"></div>

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