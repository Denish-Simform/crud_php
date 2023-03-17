function register() {
    window.location.href = "register.php";
}

function login() {
    window.location.href = "login.php";
}

function home() {
    window.location.href = "index.php";
}

function logout() {
    window.location.href = "logout.php";
}

window.onscroll = function () { scrollFunction() };

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("back-to-top-btn").style.display = "block";
    } else {
        document.getElementById("back-to-top-btn").style.display = "none";
    }
}

function topFunction() {
    document.documentElement.scrollTop = 0;
}

document.getElementById("back-to-top-btn").addEventListener("click", topFunction);