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
                <form id="login">
                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email"><br>
                    <label for="password">Heslo:</label>
                    <input type="password" id="password" name="password"><br>
                    <input type="submit" value="Prihlásiť sa">
                </form><br>
                <span class="langtext">Nemáš ešte účet? <a href="register">Zaregistruj sa</a></span>
            </div>
        </header>
        <div id="search" style="color:white;">
            <div class="welcometext">Kam to dnes bude?</div>
            <form id="searchform">
                <div id="placediv" class="formdiv">
                <label for="place">Kam cestujete?</label><br>
                <input list="placelist" class="searchinput" id="place" name="place" required>
                    <datalist id="placelist">
                        <div id="placelistdiv" class="formdiv">
                            <!-- delete after install php -->    
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
                <div id="submitdiv" class="formdiv">
                    <label></label><br>
                    <input type="image" src="styles/icons/search_white.svg" id="submitimage" onmouseover="document.querySelector('#submitimage').src='styles/icons/search_black.svg'" onmouseout="document.querySelector('#submitimage').src='styles/icons/search_white.svg'">
                </div>
            </form>
        </div>
    </body>
</html>