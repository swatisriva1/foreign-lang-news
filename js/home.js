// Megan Reddy (mr8vn)

// Expand and collapse menu

var toggle = document.getElementById('sidebarToggle');
toggle.addEventListener('click', toggleMenu);

function toggleMenu() {
    var menu = document.querySelectorAll('body');
    for (var i=0; i < menu.length; i++) {
        menu[i].classList.toggle('sb-sidenav-toggled')
    }
}
