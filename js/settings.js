// Megan Reddy (mr8vn)

// redirect user to settings/preferences page for save button click
// var save_btn_click = document.getElementById("save-btn");
// save_btn_click.addEventListener('click', () => {
//     window.location.href = "settings.php";
// });

// var save_btn_click = document.getElementById("save-btn");
// save_btn_click.addEventListener('click', () => {
//     console.log('save button clicked');
// });

// check to make sure that users have selected at least one language, topic, and newspaper
var check_preferences = setInterval(checkPreferences, 1000);

function checkPreferences()
{
    var inputs = document.getElementsByTagName('input');

    var lang_count = 0;
    var topic_count = 0;
    var news_count = 0;
    for (var i=0; i < inputs.length; i++) {
        if (inputs[i].type == "checkbox") {
            if (inputs[i].name == "lang") {
                if (inputs[i].checked) {
                    lang_count++;
                }
            }
            else if (inputs[i].name == "topic") {
                if (inputs[i].checked) {
                    topic_count++;
                }
            }
            else if (inputs[i].name == "news") {
                if (inputs[i].checked) {
                    news_count++;
                }
            }  
        }
    }

    if (lang_count < 1) {
        document.getElementById('lang_error').innerHTML = 'Please select at least one language';
    }
    else {
        document.getElementById('lang_error').innerHTML = '';
    }
    if (topic_count < 1) {
        document.getElementById('topic_error').innerHTML = 'Please select at least one topic';   
    }
    else {
        document.getElementById('topic_error').innerHTML = '';
    }
    // if (news_count < 1) {
    //     document.getElementById('news_error').innerHTML = 'Please select at least one newspaper';   
    // }
    // else {
    //     document.getElementById('news_error').innerHTML = '';
    // }
}

