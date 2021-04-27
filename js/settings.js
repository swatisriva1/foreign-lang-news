// Megan Reddy (mr8vn) and Swati Srivastava (ss3ck)

// redirect user to settings/preferences page for save button click
// var save_btn_click = document.getElementById("save-btn");
// save_btn_click.addEventListener('click', () => {
//     window.location.href = "settings.php";
// });

// prevent user from selecting more than three checkboxes or less than one checkbox
// adapted from https://stackoverflow.com/questions/43456868/javascript-limit-selected-checkboxes-to-2 
var max_checked = 3;

var lang_checkboxes = document.querySelectorAll('.langbox');
for (var i = 0; i < lang_checkboxes.length; i++)
    lang_checkboxes[i].onclick = limitLangCheck;

var topic_checkboxes = document.querySelectorAll('.topbox');
for (var i = 0; i < topic_checkboxes.length; i++)
    topic_checkboxes[i].onclick = limitTopicCheck;

function limitLangCheck() 
{
  var lang_checked_boxes = document.querySelectorAll(".langbox:checked"); 
  if (lang_checked_boxes.length > max_checked)
    return false;
}

function limitTopicCheck() 
{
  var topic_checked_boxes = document.querySelectorAll(".topbox:checked"); 
  if (topic_checked_boxes.length > max_checked)
    return false;
}

// alert users to select three languages and topics
var check_preferences = setInterval(checkPreferences, 1000);

function checkPreferences()
{
    prefs_valid = false;
    lang_valid = false;
    topic_valid = false;
    var inputs = document.getElementsByTagName('input');

    var lang_count = 0;
    var topic_count = 0;
    // var news_count = 0;
    for (var i=0; i < inputs.length; i++) {
        if (inputs[i].type == "checkbox") {
            if (inputs[i].name == "lang[]") {
                if (inputs[i].checked) {
                    lang_count++;
                }
            }
            else if (inputs[i].name == "topic[]") {
                if (inputs[i].checked) {
                    topic_count++;
                }
            }
            // else if (inputs[i].name == "news") {
            //     if (inputs[i].checked) {
            //         news_count++;
            //     }
            // }  
        }
    }

    if (lang_count < 3) {
        document.getElementById('lang_error').innerHTML = 'Please select three languages';
    }
    else {
        document.getElementById('lang_error').innerHTML = '';
        lang_valid = true;
    }
    if (topic_count < 3) {
        document.getElementById('topic_error').innerHTML = 'Please select three topics';   
    }
    else {
        document.getElementById('topic_error').innerHTML = '';
        topic_valid = true;
    }
    if(lang_valid && topic_valid) {
        prefs_valid = true;
    }
    return prefs_valid;

    // if (news_count < 1) {
    //     document.getElementById('news_error').innerHTML = 'Please select at least one newspaper';   
    // }
    // else {
    //     document.getElementById('news_error').innerHTML = '';
    // }
}

// input validation when editing information
// document.getElementById("fname").addEventListener("keyup", validateFname);
// document.getElementById("lname").addEventListener("keyup", validateLname);
// document.getElementById("email").addEventListener("keyup", validateEmail);

// disable save button until all input validated client-side
// adapted from https://stackoverflow.com/questions/36813148/javascript-enable-submit-button-when-all-input-is-valid
var save_button = document.getElementById("save-btn"); 
save_button.disabled = false;
var settings_form = document.getElementById('settings-info');
settings_form.addEventListener("input", () => {
    save_button.disabled = !validateInput();
});

// when form is submitted
function validateInput() {
    var fullValid = false;
    var fnameCheck = validateFname();
    var lnameCheck = validateLname();
    var emailCheck = validateEmail();
    var prefsCheck = checkPreferences();
    if(fnameCheck && lnameCheck && emailCheck && prefsCheck) {
        fullValid = true;
    }
    return fullValid;

}

// regex from https://www.w3resource.com/javascript/form/all-letters-field.php
function validateFname() {
    var valid = false;
    var nameInput = document.getElementById("fname");
    var nameError = document.getElementById("fname-note");
    // var letters = /^[A-Za-z]+(\s[A-Za-z]+)$/;
    var letters = /^[A-Za-z]+$/;
    if(nameInput.value == "") {
        nameError.textContent = "First name is required";
    }
    else if(!nameInput.value.match(letters)) {
        nameError.textContent = "First name may only contain letters";
    }
    else if(nameInput.value.length > 15) {
        nameError.textContent = "First name may not be longer than 15 letters";
    }
    else {
        nameError.textContent = "";
        valid = true;
    }
    return valid;
}

function validateLname() {
    var valid = false;
    var nameInput = document.getElementById("lname");
    var nameError = document.getElementById("lname-note");
    // var letters = /^[A-Za-z]+(\s[A-Za-z]+)$/;
    var letters = /^[A-Za-z]+$/;
    if(nameInput.value == "") {
        nameError.textContent = "Last name is required";
    }
    else if(!nameInput.value.match(letters)) {
        nameError.textContent = "Last name may only contain letters";
    }
    else if(nameInput.value.length > 30) {
        nameError.textContent = "Last name may not be longer than 30 letters";
    }
    else {
        nameError.textContent = "";
        valid = true;
    }
    return valid;
}

// email regex from https://stackoverflow.com/questions/46155/how-to-validate-an-email-address-in-javascript
// also referenced https://stackoverflow.com/questions/2049502/what-characters-are-allowed-in-an-email-address
function validateEmail() {
    valid = false;
    var emailInput = document.getElementById("email");
    var emailError = document.getElementById("email-note");
    // var emailPattern = /^[^\s@]+@[^\s@]+$/;
    // var emailPattern = /\S+@\S+\.\S+/;
    // var emailPattern = /\w+@\w+\.\w+/;
    var emailPattern = /^[A-Za-z0-9_-]+@[A-Za-z0-9-]+\.[A-Za-z]+$/;
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
