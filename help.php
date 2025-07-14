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
<html lang="sk"> <!-- after translation edit -->
    <head>
        <meta charset="UTF-8">
        <title><?php echo t("Zákaznícka podpora") . " | " . t("accomio | Hotely, penzióny a omnoho viac");?></title>
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

        <div class="help">
            <div class="help-title"><?php echo t("Zákaznícka podpora");?></div>
            <i><?php echo t('Máte otázky, ktoré tu nie sú zodpovedané? Potrebujete inú pomoc? Neváhajte nás <a style="color:white" href="contact">kontaktovať</a>.');?></i>

            <div class="help-title"><?php echo t("Najčastejšie problémy");?></div>
            <details>
                <summary><?php echo t("Neviem sa prihlásiť do svojho účtu accomio.");?></summary>
                <p><?php echo t('Ak ste zabudli heslo, <a style="color:white" href="contact">kontaktujte nás</a> a radi Vám s tým pomôžeme. Ak sa do svojho účtu neviete prihlásiť kvôli niečomu inému, odporúčame Vám vyskúšať to za pár minút/hodín. Môže sa jednať o krátkodobý technický výpadok nášho webu. Ak problém pretrváva, tiež nás prosím <a style="color:white" href="contact">kontaktujte</a>.');?></p>
            </details>
            <details>
                <summary><?php echo t('Neviem vytvoriť rezerváciu cez portál accomio.');?></summary>
                <p><?php echo t('Ak Vám nejde vytvoriť rezervácia cez náš portál, odporúčame Vám vyskúšať to za pár minút/hodín. Môže sa jednať o krátkodobý technický výpadok nášho webu. Tiež môžete skúsiť odhlásiť sa/prihlásiť sa a vyskúšať rezerváciu vytvoriť tak. Ak problém pretrváva, prosím <a style="color:white" href="contact">kontaktujte nás</a> a radi Vám s tým pomôžeme.');?></p>
            </details>
            <details>
                <summary><?php echo t('Potrebujem vystornovať rezerváciu vytvorenú cez portál accomio.');?></summary>
                <p><?php echo t('Vystornovať rezerváciu nie je možné online. Musíte kontaktovať konkrétny hotel, v ktorom bola vytvorená. Kontakt je uvedený na ich stránke na našom portáli. Nezabudnite, že Vám bude učtovaný storno poplatok.');?></p>
            </details>

            <div class="help-title"><?php echo t('Rezervácie');?></div>
            <details>
                <summary><?php echo t('Ako vytvorím rezerváciu cez portál accomio?');?></summary>
                <p><?php echo t('Rezerváciu cez náš portál je možné vytvoriť kliknutím na "Rezervovať" na stránke niektorého z hotelov. Nasledujúcimi krokmi budú výber dátumu a počtu osôb (ak ste tak neurobili už predtým), rekapitulácia rezervácie, zadanie osobných údajov (ak nie ste prihlásený, vtedy sa načítajú automaticky), rekapitulácia osobných údajov a nakoniec záväzné potvrdenie rezervácie. Rezervácia bola úspešná, ak sa vám zobrazí text "Vaša rezervácia bola zaslaná.".');?></p>
            </details>
            <details>
                <summary><?php echo t('Neviem vytvoriť rezerváciu cez portál accomio.');?></summary>
                <p><?php echo t('Ak Vám nejde vytvoriť rezervácia cez náš portál, odporúčame Vám vyskúšať to za pár minút/hodín. Môže sa jednať o krátkodobý technický výpadok nášho webu. Tiež môžete skúsiť odhlásiť sa/prihlásiť sa a vyskúšať rezerváciu vytvoriť tak. Ak problém pretrváva, prosím <a style="color:white" href="contact">kontaktujte nás</a> a radi Vám s tým pomôžeme.');?></p>
            </details>
            <details>
                <summary><?php echo t('Potrebujem vystornovať rezerváciu vytvorenú cez portál accomio.');?></summary>
                <p><?php echo t('Vystornovať rezerváciu nie je možné online. Musíte kontaktovať konkrétny hotel, v ktorom bola vytvorená. Kontakt je uvedený na ich stránke na našom portáli. Nezabudnite, že Vám bude učtovaný storno poplatok.');?></p>
            </details>
            <details>
                <summary><?php echo t('Kde nájdem zoznam svojich rezervácií?');?></summary>
                <p><?php echo t('Vaše rezrvácie nájdete na stránke <a style="color:white" href="contact">Môj účet</a> v záložke "História rezervácií". Nájdete tam však len rezervácie, ktoré ste robili prihlásený do svojho účtu accomio.');?></p>
            </details>

            <div class="help-title"><?php echo t('Účet accomio');?></div>
            <details>
                <summary><?php echo t('Ako si vytvorím účet accomio?');?></summary>
                <p><?php echo t('Účet accomio si vytvoríte cez stránku <a style="color:white" href="login">Prihlásiť sa</a>. Najprv zadáte email a ak ešte nie ste zaregistrovaný, budete presmerovaný registračný formulár. Ak už účet máte, bude Vám umožnené prihlásiť sa.');?></p>
            </details>
            <details>
                <summary><?php echo t('Neviem sa prihlásiť do svojho účtu accomio.');?></summary>
                <p><?php echo t('Ak ste zabudli heslo, <a style="color:white" href="contact">kontaktujte nás</a> a radi Vám s tým pomôžeme. Ak sa do svojho účtu neviete prihlásiť kvôli niečomu inému, odporúčame Vám vyskúšať to za pár minút/hodín. Môže sa jednať o krátkodobý technický výpadok nášho webu. Ak problém pretrváva, tiež nás prosím <a style="color:white" href="contact">kontaktujte</a>.');?></p>
            </details>
            <details>
                <summary><?php echo t('Ako si zmením heslo do svojho účtu accomio?');?></summary>
                <p><?php echo t('Vaše heslo si môžete zmeniť na stránke <a style="color:white" href="user">Môj účet</a> v záložke "Zmena hesla". Ak ste ho však zabudli a neviete sa prihlásiť, prosím <a style="color:white" href="contact">kontaktujte nás</a> a radi Vám s tým pomôžeme.');?></p>
            </details>
            <details>
                <summary><?php echo t('Ako si zmením svoje osobné údaje v účte accomio?');?></summary>
                <p><?php echo t('Vaše osobné údaje si môžete zmeniť na stránke <a style="color:white" href="user">Môj účet</a> v záložke "Osobné údaje".');?></p>
            </details>

            <div class="help-title"><?php echo t('Problémy s ubytovaním');?></div>
            <details>
                <summary><?php echo t('Čo mám robiť, ak ubytovacie zariadenie neexistuje alebo ma odmietlo ubytovať?');?></summary>
                <p><?php echo t('Ak ubytovacie zariadenie neexistuje alebo Vás odmietlo ubytovať, ihneď nás kontaktujte telefonicky na +421 999 999 999 a pomôžeme Vám situáciu vyriešiť. (Telefonický kontakt je možné použiť len v uvedených situáciach. Iné záležitosti riešte výhradne cez náš <a style="color:white" href="contact">kontaktný formulár</a>.)');?></p>
            </details>
            <details>
                <summary><?php echo t('Na ubytovaní mi hrozí bezprostredné nebezpečenstvo.');?></summary>
                <p><?php echo t('Ak Vám na ubytovai hrozí bezprostredné nebezpečenstvo, riaďťe sa v prvom rade pokynmi personálu hotela a záchranných zložiek. V prípade, že v takejto krízovej situácii potrebujete našu asistenciu, kontaktujte nás telefonicky na +421 999 999 999 a pomôžeme Vám situáciu vyriešiť. Nezabudnite, že najprv kontaktujte záchranné zložky a nám volajte, až keď budete mimo bezprostredného nebezpečenstva. (Telefonický kontakt je možné použiť len v uvedených situáciach. Iné záležitosti riešte výhradne cez náš <a style="color:white" href="contact">kontaktný formulár</a>.)');?></p>
            </details>

            <br><br><i><?php echo t('Máte otázky, ktoré tu nie sú zodpovedané? Potrebujete inú pomoc? Neváhajte nás <a style="color:white" href="contact">kontaktovať</a>.');?></i>
        </div>

        
        
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