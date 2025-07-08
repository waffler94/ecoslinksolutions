var menuOpen = false;

$('#burger-icon').on('click', function() {
    if (!menuOpen) {
    openMenu();
    } else {
    closeMenu();
    }
});

$('#overlay').on('click', function() {
    closeMenu();
});

function openMenu() {
    $('#burger-icon').addClass('close');
    $('#overlay').fadeIn();
    $('#menu').addClass('menu-open');
    menuOpen = true;
}

function closeMenu() {
    $('#burger-icon').removeClass('close');
    $('#overlay').fadeOut();
    $('#menu').removeClass('menu-open');
    menuOpen = false;
}


$("#overlay").click(function() {
    $("#overlay").fadeOut(300);
});

$(".toggle-submenu").click(function(e) {
    e.preventDefault();
    $(this).find(".fa-chevron-right").toggleClass('rotate-90');
    $(this).next(".submenu").slideToggle(300);
});

$(window).scroll(function() {
    if ($(window).scrollTop() > 160) {
    $('.mobile_menu').addClass('scrollDown');
    } else {
    $('.mobile_menu').removeClass('scrollDown');
    }
});

var currentYear = new Date().getFullYear();
$('.latestYear').text(currentYear);