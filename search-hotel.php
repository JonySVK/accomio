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

if (isset($_GET['htl'])) {
    $sql_name = "SELECT * FROM hotels_info WHERE hotels_id = '" . $_GET['htl'] . "'";
    $s_name = $conn->query($sql_name);
    if ($s_name->num_rows > 0) {
        $result_name = $s_name->fetch_assoc();
        $name = $result_name['name'];
    } else {
        echo '<script>alert("' . t("Niečo sa pokazilo.") . '");</script>';
    }
} elseif (isset($_GET['place'])) {
    $sql_name = "SELECT * FROM hotels_info WHERE name = '" . $_GET['place'] . "'";
    $s_name = $conn->query($sql_name);
    if ($s_name->num_rows > 0) {
        $result_name = $s_name->fetch_assoc();
        $name = $result_name['name'];
    } else {
        echo '<script>alert("' . t("Niečo sa pokazilo.") . '");</script>';
    }
}

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

    function nothing() {
        echo "<script>
                document.addEventListener('DOMContentLoaded', () => {
                    var htlslst = document.querySelector('#hotelslist');
                    htlslst.innerHTML = `<div style='font-size:2.5vh;text-align:center;color:red;'><b>" . t('V tomto hoteli sa v zvolenom termíne nenašla žiadna voľná izba.') . "</b></div>`;
                });
              </script>";
    };

    if (isset($_GET["place"])) {
        $place = (string)$_GET["place"];
        $people = ((int)$_GET["adults"]) + ((int)$_GET["kids"]);
        
        // places
        $sql_hotels = "SELECT * FROM hotels_info WHERE name = '" . $place . "'";
        $s_hotels = $conn->query($sql_hotels);

        if ($s_hotels->num_rows == 0) {
            nothing();
        } else {;
        while ($a = $s_hotels->fetch_assoc()) {
            $hotel_id = $a['hotels_id'];
        };

        // capacity
        $sql = "SELECT * FROM hotels_rooms WHERE room_capacity >= $people AND hotels_id = $hotel_id";
        $s_rooms = $conn->query($sql);

        if ($s_rooms->num_rows == 0) {
            nothing();
        } else {
        $all_rooms = [];
        while ($c = $s_rooms->fetch_assoc()) {
            $all_rooms[] = $c['rooms_id'];
        }
        
        // occupied rooms
        $occupied_rooms = [];
        foreach ($all_rooms as $room_id) {
            $sql = "SELECT * FROM bookings WHERE rooms_id = $room_id";
            $s_bookings = $conn->query($sql);

            $start = new DateTime($_GET['datefrom']);
            $end = new DateTime($_GET['dateto']);
            $interval = new DateInterval('P1D');
            $alldates = new DatePeriod($start, $interval, $end);

            $dates = [];
            foreach ($alldates as $date) {
                $dates[] = $date->format('Y-m-d');
            }
    
            while ($c = $s_bookings->fetch_assoc()) {
                $date_from_db = strtotime($c['date_from']);
                $date_to_db = strtotime($c['date_to']);
    
                foreach ($dates as $date) {
                    if (strtotime($date) >= $date_from_db && strtotime($date) <= $date_to_db) {
                        $occupied_rooms[] = $room_id;
                        break;
                    }
                }
            }
        }

        $rooms = array_diff($all_rooms, $occupied_rooms);
    
        if (empty($rooms)) {
            nothing();
        } else {
        $hotels = [];   
        foreach ($rooms as $rooms_id) {
            $sql = "SELECT * FROM hotels_info WHERE hotels_id = (SELECT hotels_id FROM hotels_rooms WHERE rooms_id = $rooms_id)";
            $s_htls = $conn->query($sql);
            $hotel = $s_htls->fetch_assoc()['hotels_id'];
            $hotels_ids = $hotel;
            $hotels[] = $hotel . "/" . $rooms_id;
        };

        //echo print_r($hotels, true);

        //$hotels_string = implode("", $hotels_ids);
        $sql = "SELECT * FROM hotels_info WHERE hotels_id = $hotels_ids ORDER BY " . $_GET['sort'];
        $s_htls = $conn->query($sql);

        $listnum = 0;
        $htlslst = '';
        while($result = $s_htls->fetch_assoc()) {
            $htl_price = 0;
            foreach ($hotels as $item) {
                list($h, $r) = explode("/", $item);
                if ($result['hotels_id'] == $h) {
                    $sql_rooms = "SELECT * FROM hotels_rooms WHERE hotels_id = '" . $result['hotels_id'] . "' AND rooms_id = '" . $r . "'";
                    $s_rooms = $conn->query($sql_rooms);
                    $room = $s_rooms->fetch_assoc();

                    $date_from = new DateTime($_GET['datefrom']);
                    $date_to = new DateTime($_GET['dateto']);
                    $nights = $date_from->diff($date_to)->days;

                    $htl_price = ((int)$room['room_price'] * (int)$_GET['adults'] * $nights) + ((int)$room['room_price'] * (int)$_GET['kids'] * (float)$result['kids_price'] * $nights);
                    $room_id = $room['rooms_id'];
                    break;
                };
            }

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
                            id: ' . $result['hotels_id'] . ',
                            name: "' . t($result['name']) . '",
                            location: "' . t($result['location']) . '",
                            country: "' . t($result['country']) . '",
                            price: ' . $htl_price . ',
                            rating: ' . $htl_rating . ',
                            list_num:' . $listnum . ',
                            url: "' . $result['url'] . '"
                        },';
                        };

                        $params = http_build_query([
                            'datefrom' => $_GET['datefrom'],
                            'dateto' => $_GET['dateto'],
                            'adults' => $_GET['adults'],
                            'kids' => $_GET['kids'],
                            'room' => $room_id
                        ]);
                        
                    echo '<script>
                                document.addEventListener("DOMContentLoaded", () => {
                                var htlslst = document.querySelector("#hotelslist")
                                if (htlslst) {
                                    var hotels = [' . rtrim($htlslst, ",") . ']
                                    hotels.forEach(hotel => {
                                        var hotelDiv = document.createElement("div")
                                        hotelDiv.onclick = function () {document.location.href = `reservation?hotel=${hotel.id}&datefrom=' . $_GET['datefrom'] . '&dateto=' . $_GET['dateto'] . '&adults=' . $_GET['adults'] . '&kids=' . $_GET['kids'] . '&room=' . $room_id . '`};
                                        hotelDiv.innerHTML = `<div style="font-size:2.5vh;text-align:center;"><b style="color:green;">' . t("Našla sa pre Vás voľná izba!") . '</b><br><br>' . t("Hotel:") . ' ${hotel.name}<br>' . t("Dátum:") . ' ' . (new DateTime($_GET["datefrom"]))->format("d.m.Y") . " - " . (new DateTime($_GET["dateto"]))->format("d.m.Y") . '<br>' . t("Počet osôb:") . ' ' . $_GET["adults"] . " + " . $_GET["kids"] . '<br>' . t("Celková cena:") . ' ' . $htl_price . '€</div><br><br><button class="res-se-btn">' . t("Zarezervujte si ju!") . '</button>`
                                        htlslst.appendChild(hotelDiv)
                                    })
                                } 
                                })
                            </script>';
                };
            };
        };
    };
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
    <head>
        <meta charset="UTF-8">
        <title><?php echo t("Vyhľadávanie") . " | " . t("accomio | Hotely, penzióny a omnoho viac");?></title>
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

        <div id="search" style="color:white;">
            <form id="searchform" method="get" action="search-hotel.php" style="display: block; text-align: center;font-size: 2.5vh;">
                <div id="placediv" class="formdiv">
                    <label for="place"><?php echo t("Kam cestujete?");?></label><br>
                    <input class="searchinput" id="placexxx" name="placexxx" style="width: 15vw;text-align: center;" value="<?php if (isset($_GET["htl"]) || isset($_GET["place"])) {echo t($name);}?>" placeholder="" disabled required>
                    <?php if (isset($_GET["htl"])) {echo '<input type="hidden" id="place" name="place" value="' . $name . '">';} elseif (isset($_GET["place"])) {echo '<input type="hidden" id="place" name="place" value="' . $name. '">';}?>
                </div><br>
                <div id="datefromdiv" class="formdiv">
                    <label for="datefrom"><?php echo t("Príchod");?></label><br>
                    <input type="date" class="searchinput" id="datefrom" name="datefrom" style="width: 15vw;text-align: center;" oninput="dateto.min = this.value" min="<?php echo date("Y-m-d"); ?>" value="<?php if (isset($_GET["datefrom"])) {echo $_GET["datefrom"];};?>" required>
                </div><br>
                <div id="datetodiv" class="formdiv">
                    <label for="dateto"><?php echo t("Odchod");?></label><br>
                    <input type="date" class="searchinput" id="dateto" name="dateto" style="width: 15vw;text-align: center;" oninput="datefrom.max = this.value" min="<?php echo date("Y-m-d"); ?>" value="<?php if (isset($_GET["dateto"])) {echo $_GET["dateto"];};?>"required>
                </div><br>
                <div id="adultsdiv" class="formdiv">
                    <label for="adults"><?php echo t("Počet dospelých");?></label><br>
                    <input type="number" class="searchinput" id="adults" name="adults" style="width: 15vw;text-align: center;" min="1" max="20" style="width: 6.5vw; text-align: center;" value="<?php if (isset($_GET["adults"])) {echo $_GET["adults"];} else {echo '1';};?>"required>
                </div><br>
                <div id="kidsdiv" class="formdiv">
                    <label for="kids"><?php echo t("Počet detí");?></label><br>
                    <input type="number" class="searchinput" id="kids" name="kids" style="width: 15vw;text-align: center;" min="0" max="10" style="width: 6.5vw; text-align: center;" value="<?php if (isset($_GET["kids"])) {echo $_GET["kids"];} else {echo '0';};?>"required>
                </div><br>
                <input type="hidden" id="sort" name="sort" value="price ASC">
                <div id="submitdiv" class="formdiv">
                    <label></label><br>
                    <input type="submit" class="nextbtn" style="margin-top: 0.2vh;" value="<?php echo t("Vyhľadať");?>">
            </div>
            </form>
        </div>

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