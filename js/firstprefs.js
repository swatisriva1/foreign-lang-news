// Megan Reddy (mr8vn) and Swati Srivastava (ss3ck)

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
var check_preferences = setInterval(checkPreferences, 200);

function checkPreferences()
{
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
    }
    if (topic_count < 3) {
        document.getElementById('topic_error').innerHTML = 'Please select three topics';   
    }
    else {
        document.getElementById('topic_error').innerHTML = '';
    }

    // keep save button disabled until input is valid
    var save_btn = document.getElementById("first-prefs-btn");
    save_btn.disabled = true;
    if(lang_count == 3 && topic_count == 3) {  // once valid input, allow save
        save_btn.disabled = false;
    }
    
    // if (news_count < 1) {
    //     document.getElementById('news_error').innerHTML = 'Please select at least one newspaper';   
    // }
    // else {
    //     document.getElementById('news_error').innerHTML = '';
    // }
}

