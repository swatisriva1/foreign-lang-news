// Swati Srivastava (ss3ck)

// redirect user to sign up for account upon button click
var clicked_btn = document.getElementById("sign-up-btn");
clicked_btn.addEventListener('click', () => {
    window.location.href = "signup.php";
});


// redirect user to home page upon login button click
var login_btn_click = document.getElementById("login-btn");
login_btn_click.addEventListener('click', () => {
    window.location.href = "index.html";
});


// disable login page until both username and password are filled
// adapted from https://stackoverflow.com/questions/46917270/javascript-disable-button-until-all-fields-are-filled/46920654
var login_btn = document.getElementById("login-btn");
login_btn.disabled = true;
var inputs = document.querySelectorAll("#inputUsername, #inputPassword");
for (var i = 0; i < inputs.length; i++) {
    inputs[i].addEventListener("input", function() {  // fires upon any keystroke that changes input value
        if(document.getElementById("inputUsername").value == "" || document.getElementById("inputPassword").value == "") {
            login_btn.disabled = true;
        } 
        else {
            login_btn.disabled = false;
        }
    });
}

