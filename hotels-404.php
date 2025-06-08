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

$url = explode('?', $_SERVER['REQUEST_URI']);

$sql_url = "SELECT * FROM hotels_info WHERE url LIKE '%" . str_replace('/accomio/', '', $url[0]) . "%'";
$s_url = $conn->query($sql_url);
if ($s_url->num_rows == 0) { // 404
    http_response_code(404);
    header("HTTP/1.1 404 Not Found");
    echo <<<TEXT
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                var hotelsite = document.querySelector("#hotelsite");
                if (hotelsite) {
                    hotelsite.innerHTML = `<img src="styles/icons/lost.svg" style="width: 20vh; height: 20vh; position: absolute; top: 30vh; left: 50%; transform: translate(-50%, -50%);">
                                            <div class="welcometext" style="padding-top: 30vh;">Po ceste ste sa asi stratili...</div>
                                            <div style="color:white;text-align:center;font-family:'Roboto', sans-serif; font-weight: 400; font-style: normal;font-size: 3vh; padding-top: 2vh;">Stránka, ktorú hľadáte, neexistuje. Skúste skontrolovať URL adresu.<br><br><i>ERROR 404</i></div>`
                }
            });
        </script>
        TEXT;      
} else { // hotel
    $htl = $s_url->fetch_assoc();
    $htl_id = $htl["hotels_id"];
    $htl_name = $htl["name"];
    $htl_location = $htl["location"];
    $htl_country = $htl["country"];
    $htl_map = $htl["map"];
    $htl_url = $htl["url"];
    $htl_description = $htl["description"];
    $htl_facility = $htl["facility"];
    $htl_contact = $htl["contact"];

    if (isset($url[1])) {
        parse_str($url[1], $get);

        $sql_rooms = "SELECT * FROM hotels_rooms WHERE rooms_id = '" . $get['room'] . "'";
        $s_rooms = $conn->query($sql_rooms);
        $room = $s_rooms->fetch_assoc();

        $sql_ht = "SELECT * FROM hotels_info WHERE hotels_id = '" . $room['hotels_id'] . "'";
        $s_ht = $conn->query($sql_ht);
        $ht = $s_ht->fetch_assoc();

        $date_from = new DateTime($get['datefrom']);
        $date_to = new DateTime($get['dateto']);
        $nights = $date_from->diff($date_to)->days;

        $htl_price = ((int)$room['room_price'] * (int)$get['adults'] * (int)$nights) + ((int)$room['room_price'] * (int)$get['kids'] * (float)$ht['kids_price'] * (int)$nights);
    } else {
        $htl_price = $htl["price"];
    };

    $sql_review = "SELECT * FROM hotels_reviews WHERE hotels_id = '" . $htl_id . "'";
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
};
?>
<!DOCTYPE html>
<!--
to-dos:
- langs
-->
<html lang="sk"> <!-- after translation edit -->
    <head>
        <meta charset="UTF-8">
        <title><?php if(isset($htl_name)) {echo $htl_name . " | ";} ?>accomio | Hotely, penzióny a omnoho viac</title> <!---->
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

        <div id="hotelsite">
            <div class="hotelname"><?php echo $htl_name;?></div>
            <div class="hotellocation"><?php echo $htl_location;?>, <?php echo $htl_country;?></div>
            <div class="hotelicons">
                <button class="reservbtn" onclick="window.location.href = '<?php if (isset($url[1])) {echo 'reservation?hotel=' . $htl_id . '&datefrom=' . $get['datefrom'] . '&dateto=' . $get['dateto'] . '&adults=' . $get['adults'] . '&kids=' . $get['kids'] . '&room=' . $get['room'];} else {echo 'search-hotel?htl=' . $htl_name;} ?>'">Rezervovať</button>  
                <abbr style="text-decoration:none;" title="Kontaktovať"><a href="mailto:<?php echo $htl_contact;?>" onclick="navigator.clipboard.writeText('<?php echo $htl_contact;?>')"><img class="hotelicon" src="styles/icons/mail.svg"></a></abbr>
                <abbr style="text-decoration:none;" title="Zdielať"><a onclick="navigator.clipboard.writeText(window.location.href)"><img class="hotelicon" src="styles/icons/share.svg"></a></abbr>
            </div>
            <div class="space"></div>
            <div class="left">
                <img class="hotelimg" src="styles/hotels/<?php echo $htl_url;?>.png"><br>
                <?php echo $htl_map;?>
            </div>
            <div class="right">
                <div class="hoteldesciption"><?php echo $htl_description;?></div><br>
                <div class="hotelfacility">Vybavenie: <br> <?php echo $htl_facility;?></div><br>
                <div class="hotelprice">Cena: <?php if (isset($url[1])) {echo "<abbr title='Cena za počet nocí: " . $nights . " a počet osôb: " . $get["adults"] . " + " . $get["kids"] . "'>" . $htl_price . "</abbr>";} else {echo "<abbr title='Cena za počet nocí: 1 a počet osôb: 1 + 0'>" . $htl_price . "</abbr>";}?>€</div>
                <hr>
                <div class="hotelreview">
                    <?php 
                    $sql_review = "SELECT * FROM hotels_reviews WHERE hotels_id = '" . $htl_id . "'";
                    $s_review = $conn->query($sql_review);
                    ?>
                    <div class="reviewintro"><b>Recenzie</b><div class="avg"><?php echo $htl_rating;?>★</div><br>Počet recenzií: <?php echo $s_review->num_rows;?></div>
                    <?php
                        if (!$s_review->num_rows == 0) {
                            while ($review = $s_review->fetch_assoc()) {
                                if ($review["review"] == "") {
                                    continue;
                                }
                                echo "<div class='review'>
                                        <div class='reviewname'>" . $review["name"] . "</div>
                                        <div class='reviewrating'>" . $review['rating'] . "★</div>
                                        <div class='reviewtext'>" . $review["review"] . "</div>
                                        </div>";
                            }
                        }
                    ?>
            </div>
        </div>

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