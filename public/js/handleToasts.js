url = new URL(window.location.href);
url.searchParams.delete("mensagem");
url.searchParams.delete("color");
window.history.pushState('object or string', 'Title', url)

$(document).ready(function(){
    setTimeout(function(){
        $('.toast').addClass('showing');
    }, 5000);
});