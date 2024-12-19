<!DOCTYPE html>
<!--
to-dos:
- langs
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
                <a onclick="langbox()" class="aimg"><div class="headerdiv" id="hi1">
                    <abbr class="headertext" id="ht1" title="Zmeniť jazyk"><img src="styles/icons/language.svg" class="headerimgs"></abbr>
                    <div id="hi1style" style="display:inline;"></div>
                </div></a>
                <a href="help" class="aimg"><div class="headerdiv" id="hi2">
                    <abbr class="headertext" id="ht2" title="Zákaznícka podpora"><img src="styles/icons/help.svg" class="headerimgs"></abbr>
                </div></a>
                <a onclick="loginbox()" class="aimg"><div class="headerdiv" id="hi3">
                    <abbr class="headertext" id="ht3" title="Prihlásiť sa/Registrovať sa"><img src="styles/icons/account.svg" class="headerimgs"></abbr>
                    <div id="loginstyle" style="display:inline;"></div>
                </div></a>
            </nav>
            <div id="lang-box">
                <span class="langtext">Choose your language:</span><br>
                <abbr title="English"><img src="styles/languages/english.svg" id="lang-en" class="langimg"></abbr>
                <abbr title="Deutsch"><img src="styles/languages/german.svg" id="lang-de" class="langimg"></abbr>
                <abbr title="Slovensky"><img src="styles/languages/slovak.svg" id="lang-sk" class="langimg"></abbr>
                <abbr title="Česky"><img src="styles/languages/czech.svg" id="lang-cz" class="langimg"></abbr>
            </div>
            <div id="login-box">
                <span class="langtext">Prihláste sa:</span><br>
                <form id="login" method="post" action="db-login.php">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email"><br>
                    <label for="password">Heslo:</label>
                    <input type="password" id="password" name="password"><br>
                    <input type="submit" value="Prihlásiť sa">
                </form><br>
                <span class="langtext">Nemáte ešte účet? <a href="login">Zaregistrujte sa</a></span>
            </div>
        </header>
        <div class="welcometext">Po ceste ste sa asi stratili...</div>
        <div style="color:white;text-align:center;font-family: 'Roboto', sans-serif; font-weight: 400; font-style: normal; font-size: 3vh; padding-top: 2vh;">Stránka, ktorú hľadáte, neexistuje. Skúste skontrolovať URL adresu.<br><br>ERROR 404</div>
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