var langboxvisible = false
function langbox() {
    var langstyle = document.querySelector("#hi1style")
    if (langboxvisible === false) {
        langstyle.innerHTML = "<style>#lang-box {visibility: visible; height: auto; width: 20vw;}</style>"
        langboxvisible = true
    } else {
        langstyle.innerHTML = "<style>#lang-box {visibility: hidden; height: 0; width: 0;}</style>"
        langboxvisible = false
    }
}

var loginboxvisible = false
function loginbox() {
    var loginstyle = document.querySelector("#hi1style")
    if (loginboxvisible === false) {
        loginstyle.innerHTML = "<style>#login-box {visibility: visible; height: auto; width: 20vw;}</style>"
        loginboxvisible = true
    } else {
        loginstyle.innerHTML = "<style>#login-box {visibility: hidden; height: 0; width: 0;}</style>"
        loginboxvisible = false
    }
}

var placeholder = ""
var cities = ["Bratislava", "Viedeň", "Berlín", "Londýn"] // update after connect database
var currentCityIndex = 0
var charIndex = 0
var isDeleting = false

setInterval(function () {
    const currentCity = cities[currentCityIndex];

    placeholder = currentCity.slice(0, charIndex++);
    if (charIndex - 1 > currentCity.length) {
        placeholder = ""
        currentCityIndex = (currentCityIndex + 1) % cities.length
        charIndex = 0
    }

    document.querySelector('#place').placeholder = placeholder
}, 5);
