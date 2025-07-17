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
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
    <head>
        <meta charset="UTF-8">
        <title><?php echo t("Všeobecné podmienky") . " | " . t("accomio | Hotely, penzióny a omnoho viac");?></title>
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

        <?php echo t('<div class="text">
            <div class="text-heading">Všeobecné podmienky</div>
            <div class="text-title">1. PREVÁDZKOVATEĽ</div>
            <div>Prevádzkovateľom portálu accomio je Bilbo Bublík so sídlom v Grófstve, Stredozem. Kontaktovať je ho možné emailom na <a href="mailto:bilbo@bublik.com">bilbo@bublik.com</a> alebo poštou na adrese Vreckany 1, Hobitov, Grófstvo, Stredozem. Prevádzkovateľ nie je poskytovateľom ubytovacích služieb v ponúkaných hoteloch. Portál accomio ponúka len možnosť vyhľadávania a rezervácie ubytovania v hoteloch, penziónoch a iných ubytovacích zariadeniach. Prevádzkovateľ nezodpovedá za kvalitu služieb poskytovaných jednotlivými ubytovacími zariadeniami.</div>
            <div class="text-title">2. POSKYTOVATELIA UBYTOVACÍCH SLUŽIEB</div>
            <div>Poskytovatelia ubytovacích služieb sú jednotlivé hotely ako partneri portálu accomio, ktorý využívajú ako rezervačný nástroj. Sú zodpovední za kvalitu poskytovaných služieb. V prípade sťažností sú hostia oprávnení kontaktovať ich cez kontakty uvedené na tomto portáli. V prípade vážnych sťažností alebo nezrovnalostí, kontaktujte prosím aj náš portál cez kontakty uvedené na našej stránke, aby sme mohli podniknúť náležité opatrenia.</div>
            <div class="text-title">3. HOSŤ</div>
            <div>Hosťom sa rozumie každá osoba, ktorá si rezervuje ubytovanie prostredníctvom portálu accomio. Hosť je povinný poskytnúť pravdivé a úplné informácie pri rezervácii ubytovania. V prípade, že hosť poskytne nepravdivé alebo neúplné informácie, prevádzkovateľ si vyhradzuje právo zrušiť rezerváciu.</div>
            <div class="text-title">4. REZERVÁCIA UBYTOVANIA</div>
            <div>Rezervácia ubytovania sa uskutočňuje prostredníctvom portálu accomio. Hosť si vyberie požadované ubytovacie zariadenie, termín a počet osôb. Po potvrdení rezervácie hosť obdrží potvrdenie rezervácie na zadaný email. Rezervácia je záväzná pre obe strany. V prípade storna tejto objednávky sa postupuje podľa týchto Podmienok.</div>
            <div class="text-title">5. POVINNOSTI HOSŤA</div>
            <div>Hosť je povinný dodržiavať všetky pokyny a pravidlá ubytovacieho zariadenia, v ktorom je ubytovaný. Hosť je zodpovedný za škody spôsobené na majetku ubytovacieho zariadenia počas jeho pobytu. V prípade poškodenia majetku ubytovacieho zariadenia, hosť súhlasí s úhradou vzniknutej škody.</div>
            <div class="text-title">6. STORNO REZERVÁCIE ZO STRANY HOSŤA</div>
            <div>Hosť má právo kedykoľvek zrušiť rezerváciu ubytovania. V prípade storna rezervácie v lehote viac ako 90 dní pred plánovaným začiatkom pobytu, storno poplatok je vo výške 20 percent z plánovanej ceny ubytovania. V prípade storna v lehote menej ako 90 a viac ako 30 dní pred plánovaným začiatkom pobytu, storno poplatok je vo výške 50 percent z plánovanej ceny ubytovania. V prípade storna v lehote menej ako 30 dní pred plánovaným začiatkom pobytu, storno poplatok je vo výške 100 percent z plánovanej ceny ubytovania.</div>
            <div class="text-title">7. STORNO REZERVÁCIE ZO STRANY POSKYTIVATEĽA</div>
            <div>Poskytovateľ ubytovacích služieb si vyhradzuje právo zrušiť rezerváciu v prípade, že hosť poruší podmienky ubytovania alebo ak sa vyskytnú nepredvídateľné okolnosti, ktoré znemožňujú poskytnutie ubytovania. V takom prípade poskytovateľ ubytovacích služieb informuje hosťa o zrušení rezervácie a vráti mu všetky zaplatené poplatky. V prípade stažností týkajúcich sa tohto bodu Podmienok, kontaktujte nás cez kontakty uvedené na našej stránke.</div>
            <div class="text-title">8. ZÁVEREČNÉ USTANOVENIA</div>
            <div>Tieto Všeobecné podmienky sú platné od 14. júla 1789. Prevádzkovateľ si vyhradzuje právo na zmenu týchto Podmienok. O zmene Podmienok bude hosť informovaný prostredníctvom emailu alebo na stránke portálu accomio. Hosť je povinný oboznámiť sa s aktuálnymi Podmienkami pred každou rezerváciou ubytovania. Podmienky platia v každej jurisdikcii na svete.</div>
        </div>');?>

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