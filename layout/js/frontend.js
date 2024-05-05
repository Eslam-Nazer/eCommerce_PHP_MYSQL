$(function () {
    'use strict';


    // Switch Between Login & Signup
    $('.login-page h1 span').click(function () {
        $(this).addClass('selected').siblings().removeClass('selected');
        $('.login-page form').hide();
        $('.' + $(this).data('class')).fadeIn(100);
    });

    // Fire The Select Box
    $("select").selectBoxIt({
        autoWidth: false,

        // Uses the jQuery 'fadeIn' effect when opening the drop down
        showEffect: "fadeIn",

        // Sets the jQuery 'fadeIn' effect speed to 400 milleseconds
        showEffectSpeed: 400,

        // Uses the jQuery 'fadeOut' effect when closing the drop down
        hideEffect: "fadeOut",

        // Sets the jQuery 'fadeOut' effect speed to 400 milleseconds
        hideEffectSpeed: 400
    });

});