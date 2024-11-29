<!DOCTYPE html>
<!--
to-dos:
- langs
-->
<html>
    <head>
        <title>accomio | Hotely, penzióny a omnoho viac</title>
        <link rel="icon" type="image/x-icon" href="styles/icons/icon.ico">
        <link rel='stylesheet' href='styles/basic.css'>
        <script src='scripts/basic.js'></script>
    </head>
    <body>
        <header>
            <div class="title">accomio</div>
            <nav class="headerbtns">
                <a onclick="langbox()" class="aimg"><div class="headerdiv" id="hi1">
                    <span class="headertext" id="ht1">Zmeniť jazyk</span>
                    <img src="styles/icons/language.svg" class="headerimgs">
                    <div id="hi1style" style="display:inline;"></div>
                </div></a>
                <a href="help" class="aimg"><div class="headerdiv" id="hi2">
                    <span class="headertext" id="ht2">Zákaznícka podpora</span>
                    <img src="styles/icons/help.svg" class="headerimgs">
                </div></a>
                <a href="account" class="aimg"><div class="headerdiv" id="hi3">
                    <span class="headertext" id="ht3">Prihlásiť sa/Registrovať sa</span>
                    <img src="styles/icons/account.svg" class="headerimgs">
                </div></a>
            </nav>
            <div id="lang-box">
                <span class="langtext">Choose your language:</span><br>
                <img src="styles/languages/english.svg" id="lang-en" class="langimg">
                <img src="styles/languages/german.svg" id="lang-de" class="langimg">
                <img src="styles/languages/slovak.svg" id="lang-sk" class="langimg">
                <img src="styles/languages/czech.svg" id="lang-cz" class="langimg">
            </div>
        </header>
        <div id="search" style="color:white;">
            <div class="welcometext">Kam to dnes bude?</div>
            <form id="searchform">
                <input type="text" id="place" name="place">
                <input type="date" id="datefrom" name="datefrom" oninput="dateto.min = this.value">
                <input type="date" id="dateto" name="dateto" oninput="datefrom.max = this.value">
            </form>
        </div>
    </body>
</html>