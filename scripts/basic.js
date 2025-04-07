var langboxvisible = false
function langbox() {
    var langstyle = document.querySelector("#hi1style")
    if (langboxvisible === false) {
        langstyle.innerHTML = "<style>#lang-box {visibility: visible; height: auto; width: 15vw;}</style>"
        langboxvisible = true
    } else {
        langstyle.innerHTML = "<style>#lang-box {visibility: hidden; height: 0; width: 0;}</style>"
        langboxvisible = false
    }
}

var userboxvisible = false
function userbox() {
    var userstyle = document.querySelector("#hi1style")
    if (userboxvisible === false) {
        userstyle.innerHTML = "<style>#user-box {visibility: visible; height: auto; width: 15vw;}</style>"
        userboxvisible = true
    } else {
        userstyle.innerHTML = "<style>#user-box {visibility: hidden; height: 0; width: 0;}</style>"
        userboxvisible = false
    }
}


if (Math.max(document.body.scrollHeight, document.documentElement.scrollHeight, document.body.offsetHeight, document.documentElement.offsetHeight, document.body.clientHeight, document.documentElement.clientHeight) > window.innerHeight) {
    document.querySelector("#headername").style = "margin: 0 0 0.65vh -0.1vw;"
} else {
    document.querySelector("#headername").style = "margin: 0 0 1.6vh -0.1vw;"
}

var plchldr = document.querySelector("#place")
if (plchldr && plchldr.value === "") {
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
    }, 500);
}

