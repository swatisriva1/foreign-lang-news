// Swati Srivastava (ss3ck)

document.getElementById("inputName").addEventListener("keyup", validateName);
document.getElementById("inputEmailAddress").addEventListener("keyup", validateEmail);
document.getElementById("inputUsername").addEventListener("keyup", validateUsername);
document.getElementById("inputPassword").addEventListener("keyup", validatePassword);
document.getElementById("inputPassword").addEventListener("keyup", confirmPassword);
document.getElementById("inputConfirmPassword").addEventListener("keyup", confirmPassword);

// when form is submitted
function validateInput() {
    var fullValid = false;
    var nameCheck = validateName();
    var userCheck = validateUsername();
    var emailCheck = validateEmail();
    var pwdCheck = validatePassword();
    var confirmPwd = confirmPassword();
    if(nameCheck && userCheck && emailCheck && pwdCheck && confirmPwd) {
        fullValid = true;
    }
    if(fullValid) {
        window.alert("Thanks for creating an account! You will now be redirected to login.");
    }
    return fullValid;

}

// regex from https://www.w3resource.com/javascript/form/all-letters-field.php
function validateName() {
    var valid = false;
    var nameInput = document.getElementById("inputName");
    var nameError = document.getElementById("msg_name");
    var letters = /^[A-Za-z]+(\s[A-Za-z]+)$/;
    if(nameInput.value == "") {
        nameError.textContent = "Name is required";
    }
    else if(!nameInput.value.match(letters)) {
        nameError.textContent = "Please enter full name, name may only contain letters";
    }
    else if(nameInput.value.length > 30) {
        nameError.textContent = "Name may not be longer than 30 letters";
    }
    else {
        nameError.textContent = "";
        valid = true;
    }
    return valid;
}

// email regex from https://stackoverflow.com/questions/46155/how-to-validate-an-email-address-in-javascript
function validateEmail() {
    valid = false;
    var emailInput = document.getElementById("inputEmailAddress");
    var emailError = document.getElementById("msg_email");
    // var emailPattern = /^[^\s@]+@[^\s@]+$/;
    var emailPattern = /\S+@\S+\.\S+/;
    if(emailInput.value == "") {
        emailError.textContent = "Email is required";
    }
    else if(!emailInput.value.match(emailPattern)) {
        emailError.textContent = "Email must follow this format -- jane@domain.com";
    }
    else {
        emailError.textContent = "";
        valid = true;
    }
    return valid;
}

function validateUsername() {
    valid = false; 
    var usernameInput = document.getElementById("inputUsername");
    var usernameError = document.getElementById("msg_username");
    var chars = /^[a-z0-9_]+$/;
    if(usernameInput.value == "") {
        usernameError.textContent = "Username is required";
    }
    else if(!usernameInput.value.match(chars)) {
        usernameError.textContent = "Username may only contain lowercase letters, numbers, and _";
    }
    else if(usernameInput.value.length < 5 || usernameInput.value.length > 12) {
        usernameError.textContent = "Username must be 5-12 characters";
    }
    else {
        usernameError.textContent = "";
        valid = true;
    }
    return valid;
}

// password regex from https://www.w3resource.com/javascript/form/password-validation.php
// also referenced https://perlancar.wordpress.com/2018/10/05/matching-several-things-in-no-particular-order-using-a-single-regex/ 
function validatePassword() {
    var valid = false;
    var pwdInput = document.getElementById("inputPassword");
    var pwdPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*])/;  //.{8,20}$/
    var pwdError = document.getElementById("msg_pwd");
    if(pwdInput.value == "") {
        pwdError.textContent = "Password is required";
    }
    else if(!pwdInput.value.match(pwdPattern)) {
        pwdError.textContent = "Password must be 8-20 characters and contain at least one lowercase letter, one uppercase letter, one number, and one special character";
    }
    else if(pwdInput.value.length < 8 || pwdInput.value.length > 20) {
        pwdError.textContent = "Password must be 8-20 characters";
    }
    else {
        pwdError.textContent = "";
        valid = true;
    }
    return valid;
}

//adapted from https://stackoverflow.com/questions/21727317/how-to-check-confirm-password-field-in-form-without-reloading-page/21727518
function confirmPassword() {
    var valid = false;
    var pwd = document.getElementById('inputPassword');
    var confirmPwd =  document.getElementById('inputConfirmPassword');
    var confirmPwdError = document.getElementById('msg_confirm_pwd');
    if (pwd.value === confirmPwd.value && pwd.value !== "") {
        valid = true;
        confirmPwdError.style.color = 'green';
        confirmPwdError.textContent = 'Passwords match ✔';
    } 
    else {
        confirmPwdError.style.color = '#b81414'; 
        confirmPwdError.textContent = "Passwords don't match";
    }
    return valid;
  }