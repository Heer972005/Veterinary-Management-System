$("#registerForm").submit(function () {
    let password = $("input[name='password']").val();

    if (password.length < 6) {
        alert("Password must be at least 6 characters");
        return false;
    }
});


$("form").submit(function () {
    let name = $("input[name='petName']").val();

    if (name.length < 2) {
        alert("Pet name too short");
        return false;
    }
});

document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        document.querySelector(".loader").style.display = "none";
    }, 1000); // 1 second delay
});



function toggleTheme() {
    document.body.classList.toggle("dark");
}