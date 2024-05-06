$(function () {
    'use strict';

    // Dashboard card head
    $('.toggle-info').click(function () {
        $(this).toggleClass('selected').parent().next('.card-body').fadeToggle('100');

        if ($(this).hasClass('selected')) {
            $(this).html('<i class="fa-solid fa-square-plus fa-lg">');
        } else {
            $(this).html('<i class="fa-solid fa-minus fa-lg">');
        }
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

    // Confirmation Message On Button
    $('.confirm').click(function () {
        return confirm('Are You Sure?')
    });

    // Category view options
    $('.cat h3').click(function () {
        $(this).next('.full-view').fadeToggle();
    });
});