$('.adminlte-darkmode-widget').on('click', () => {
    if ($('.sidebar-mini').hasClass('dark-mode')) {
        $('.form-control').removeClass('bg-dark');
        $('.form-control').removeClass('border-dark');
        $('table').removeClass('bg-dark');
    } else {
        $('.form-control').addClass('bg-dark');
        $('table').addClass('bg-dark');
        $('.form-control:disabled').addClass('border-dark');
    }
})

$(document).ready(() => {
    if ($('.sidebar-mini').hasClass('dark-mode')) {
        $('.form-control').addClass('bg-dark');
        $('.form-control:disabled').addClass('border-dark');
        $('table').addClass('bg-dark');
    } else {
        $('.form-control').removeClass('bg-dark');
        $('.form-control').removeClass('border-dark');
        $('table').removeClass('bg-dark');
    }
})