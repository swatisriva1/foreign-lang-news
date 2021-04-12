// Megan Reddy (mr8vn)

// expand and collapse menu

var toggle = document.getElementById('sidebarToggle');
toggle.addEventListener('click', toggleMenu);

function toggleMenu() {
    var menu = document.querySelectorAll('body');
    for (var i=0; i < menu.length; i++) {
        menu[i].classList.toggle('sb-sidenav-toggled')
    }
}

// redirect user to settings/preferences page for edit preferences button click
var preferences_btn_click = document.getElementById("preferences-btn");
preferences_btn_click.addEventListener('click', () => {
    window.location.href = "settings.php";
});