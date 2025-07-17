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

if (document.documentElement.scrollHeight > window.innerHeight) {
    document.querySelector("#headername").style.setProperty("margin", "0 0 0.65vh -0.1vw", "important");
} else {
    document.querySelector("#headername").style.setProperty("margin", "0 0 0.65vh -0.1vw", "important");
}

function copy() {
    var copyText = document.querySelector("#copy").innerHTML = "Content has been copied to the clipboard."
    var copyText = document.querySelector("#copy").style.setProperty("visibility", "visible", "important");
    setTimeout(() => {
        var copyText = document.querySelector("#copy").innerHTML = ""
        var copyText = document.querySelector("#copy").style.setProperty("visibility", "hidden", "important");  
    }, 2000)
}

document.addEventListener('keydown', function(event) {
  if (event.ctrlKey && event.key.toLowerCase() === 'e') {
    event.preventDefault();
    document.location.href = "localhost/accomio/admin"
  }
});
