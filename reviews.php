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

if (!isset($_GET["b"]) || !is_numeric($_GET["b"])) {
    echo "<script>alert('Niečo sa pokazilo.'); window.location.href = '/accomio/user'</script>";
    exit();
}

$sql_booking = "SELECT * FROM bookings WHERE bookings_id = '" . $_GET["b"] . "' AND customers_id = (SELECT customers_id FROM customers WHERE code = '" . $_SESSION["cd"] . "' AND log = '" . $_SESSION["lg"] . "')";
$s_booking = $conn->query($sql_booking);
$booking = $s_booking->fetch_assoc();
if ($s_booking->num_rows == 0) {
    echo "<script>alert('Niečo sa pokazilo.'); window.location.href = '/accomio/user' </script>";
}

$sql_reviews = "SELECT * FROM hotels_reviews WHERE bookings_id = '" . $_GET["b"] . "'";
$s_reviews = $conn->query($sql_reviews);
$reviews = $s_reviews->fetch_assoc();
if ($s_reviews->num_rows > 0) {
echo "<script>alert('Recenziu k tejto rezervácii ste už pridali.'); window.location.href = '/accomio/user'</script>";
    exit();
}

$sql_hotel = "SELECT * FROM hotels_info WHERE hotels_id =" . $booking['hotels_id'];
$s_hotel = $conn->query($sql_hotel);
$hotel = $s_hotel->fetch_assoc();
if ($s_hotel->num_rows == 0) {
    echo "<script>alert('Niečo sa pokazilo.'); window.location.href = '/accomio/user'</script>";
    exit();
}



if(isset($_POST['rating'])) {
        if ($_POST['name'] == '1') {
            $name = "SELECT * FROM customers WHERE code = '" . $_SESSION["cd"] . "' AND log = '" . $_SESSION["lg"] . "'";
            $name = $conn->query($name);
            $name = $name->fetch_assoc();
            $name = $name['name'];
        } else {
            $name = 'Anonymný hosť';
        }
        $sql_review = "INSERT INTO hotels_reviews (reviews_id, bookings_id, hotels_id, rating, review, date, name) VALUES (NULL, '" . $_GET["b"] . "'," . $booking['hotels_id'] . ", '" . $_POST['rating'] . "', '" . $_POST['review'] . "', NOW(), '" . $name . "')";
        $conn->query($sql_review);
        if ($conn->affected_rows > 0) {
            echo "<script>
            document.addEventListener('DOMContentLoaded', () => {
                var contactform = document.querySelector('#contactform');
                if (contactform) {
                    contactform.innerHTML = `<span style='padding-top:5vh;font-weight:800;'>Vaša recenzia bola úspešne odoslaná!</span>`;
                }
            });
        </script>";
        } else {
            echo "<script>
            document.addEventListener('DOMContentLoaded', () => {
                var contactform = document.querySelector('#contactform');
                if (contactform) {
                    contactform.innerHTML = `<span style='padding-top:5vh;font-weight:800;color:red;'>Pri odosielaní recenzie došlo k chybe. Skúste to prosím neskôr.</span>`;
                }
            });
        </script>";
        }
}
?>
<!DOCTYPE html>
<html lang="sk"> <!-- after translation edit -->
    <head>
        <meta charset="UTF-8">
        <title>Pridať recenziu | accomio | Hotely, penzióny a omnoho viac</title>
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

        <div class="text" style="text-align: center;font-size: 3.25vh;">
            <form method="post" action="" class="contactform" id="contactform">
                <input type="hidden" name="bookings_id" value="<?php echo $_GET["b"];?>" required><br>
                <span style="">Ako hodnotíte "<?php echo $hotel["name"]; ?>"?</span><br>
                <div class="rating">
                    <input type="radio" id="star5" name="rating" value="5"><label for="star5">★</label>
                    <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                    <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                    <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
                    <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
                </div><br>
                <textarea name="review" class="contactinput" placeholder="Vaše hodnotenie (nepovinné)" style=" width: 20vw;height:18vh;"></textarea><br>
                <input type="checkbox" name="name" value="1" class="contactcheckbox" style="height:20px;width:20px;;margin: 0 -0.5vw 4vh 0;" checked><label style="font-size: 2.3vh;"> Zobraziť pri recenzii moje meno</label><br>
                <input type="submit" value="Odoslať" class="contactinput" id="contactsubmit">
            </form>
        </div>

        <style>

</style>

<form class="rating">
</form>
        
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