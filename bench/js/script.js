/*
* @Author: Kafei59
* @Date:   2016-03-29 15:38:40
* @Last Modified by:   Kafei59
* @Last Modified time: 2016-03-29 15:54:41
*/

function menuToggle() {
    var toggled = Cookies.get('menu-toggled');

    if (toggled) {
        $("#wrapper").removeClass("toggled");
        $("#menu-toggle").addClass('open');
    } else {
        $("#wrapper").addClass("toggled");
        $("#menu-toggle").removeClass('open');
    }
}

$(document).ready(function() {
    menuToggle();
});

$(document).on('click', "#menu-toggle", function(e) {
    if ($(this).hasClass('open')) {
        Cookies.remove('menu-toggled');
    } else {
        Cookies.set('menu-toggled', true);
    }

    menuToggle();
});

var $wrapper = $('#wrapper');
$wrapper.swipe( {
    swipeLeft:function() {
        Cookies.remove('menu-toggled');
        menuToggle();
    },

    swipeRight:function() {
        Cookies.set('menu-toggled', true);
        menuToggle();
    }
});

(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-74897023-1', 'auto');
ga('send', 'pageview');
