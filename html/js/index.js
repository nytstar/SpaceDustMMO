function toggleLogin() {
    var element = document.getElementById("login-content");
    element.classList.toggle("active");
    if (element.classList.contains("active")) {
        element.style.display = "block";
    } else {
        element.style.display = "none";
    }
}
var element = document.getElementById("login-content");
if (element.classList.contains("active")) {
    element.style.display = "block";
} else {
    element.style.display = "none";
}