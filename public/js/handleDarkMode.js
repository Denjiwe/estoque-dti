$('.adminlte-darkmode-widget').on('click', () => {
    if ($('.sidebar-mini').hasClass('dark-mode')) {
        $('.form-control').removeClass('bg-dark');
        $('.form-select').removeClass('bg-dark');
        $('.form-select').removeClass('border-dark');
        $('.form-control').removeClass('border-dark');
        $('td').css('background-color', '');
        $('th').css('background-color', '');
        $('th').css('color', '');
        $('td').css('color', '');
    } else {
        $('.form-control').addClass('bg-dark');
        $('.form-select').addClass('bg-dark');
        $('table').addClass('bg-dark');
        $('.form-select:disabled').addClass('border-dark');
        $('.form-control:disabled').addClass('border-dark');
        $('td').css('background-color', 'black');
        $('th').css('background-color', 'black');
        $('td').css('color', 'white');
        $('th').css('color', 'white');
    }
})

$(document).ready(() => {
    if ($('.sidebar-mini').hasClass('dark-mode')) {
        $('.form-control').addClass('bg-dark');
        $('.form-select').addClass('bg-dark');
        $('.form-select:disabled').addClass('border-dark');
        $('.form-control:disabled').addClass('border-dark');
        $('td').css('background-color', 'black');
        $('td').css('color', 'white');
        $('th').css('background-color', 'black');
        $('th').css('color', 'white');
    } else {
        $('.form-control').removeClass('bg-dark');
        $('.form-select').removeClass('bg-dark');
        $('.form-select').removeClass('border-dark');
        $('.form-control').removeClass('border-dark');
        $('td').css('background-color', '');
        $('th').css('background-color', '');
        $('th').css('color', '');
        $('td').css('color', '');
    }
})

$(document).on('DOMNodeInserted', 'tr', function() {
    if ($('.sidebar-mini').hasClass('dark-mode')) {
        $(this).find('td').css('background-color', 'black');
        $(this).find('td').css('color', 'white');
    }
});