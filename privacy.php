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
?>
<!DOCTYPE html>
<html lang="sk"> <!-- after translation edit -->
    <head>
        <meta charset="UTF-8">
        <title>Ochrana súkromia | accomio | Hotely, penzióny a omnoho viac</title>
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

        <div class="text">
            <div class="text-heading">Ochrana súkromia</div>
            <div class="text-title">1. IDENTIFIKAČNÉ ÚDAJE PREVÁZDKOVATEĽA INFORMAČNÉHO SYSTÉMU</div>
            <div>Prevádzkovateľom portálu accomio je Bilbo Bublík so sídlom Vreckany 1, Hobitov, Grófstvo, Stredozem. Kontaktovať ho môžete poštou alebo emailom na <a href="mailto:bilbo@bublik.com">bilbo@bublik.com</a>.</div>
            <div class="text-title">2. ÚČEL A ROZSAH SPRACOVANIA OSOBNÝCH ÚDAJOV</div>
            <div>Osobné údaje sú spracovávané v súlade s platnými právnymi predpismi. Prevádzkovateľ spracováva osobné údaje návštevníkov a zákaznikov portálu za účelom poskytovania služieb, komunikácie a zlepšovania používateľskej skúsenosti. K osobným údajom majú prístup aj naši partneri - poskytovalia ubytovacích služieb -, ale len k tým, ktoré sú súčasťou rezervácie.</div>
            <div class="text-title">3. PRÁVA DOTKNUTÝCH OSÔB</div>
            <div>Dotknuté osoby majú právo na prístup k svojim osobným údajom, ich opravu, vymazanie alebo obmedzenie spracovania. Taktiež majú právo na prenositeľnosť údajov a právo namietať proti spracovaniu. V prípade otázok alebo žiadostí týkajúcich sa ochrany osobných údajov nás môžete kontaktovať cez kontakty uvedené na našej stránke.</div>
            <div class="text-title">4. BEZPEČNOSŤ OSOBNÝCH ÚDAJOV</div>
            <div>Prevádzkovateľ prijíma primerané technické a organizačné opatrenia na ochranu osobných údajov pred neoprávneným prístupom, zmenou, zverejnením alebo zničením. Všetky osobné údaje sú spracovávané v súlade s platnými právnymi predpismi o ochrane osobných údajov.</div>
            <div class="text-title">5. ZÁVEREČNÉ USTANOVENIA</div>
            <div>Prevádzkovateľ si vyhradzuje právo na zmenu týchto podmienok ochrany osobných údajov. O všetkých zmenách budú návštevníci a zákazníci informovaní prostredníctvom portálu. Pokračovaním v používaní portálu po zmene týchto podmienok súhlasíte s novými podmienkami.</div>
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