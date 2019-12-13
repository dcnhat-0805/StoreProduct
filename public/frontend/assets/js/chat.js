$(document).ready(function () {

    $('#prime').click(function () {
        toggleFab();
    });


//Toggle chat and links
    function toggleFab() {
        $('#prime i').toggleClass('fa-commenting-o');
        $('#prime i').toggleClass('fa-times');
        // $('#prime').toggleClass('is-active');
        // $('#prime').toggleClass('is-visible');
        $('#prime').toggleClass('is-float');
        $('.chat').toggleClass('is-visible');
        $('.fab').toggleClass('is-visible');
        hideChat();

    }

    function hideChat() {
        $('#chat_converse').css('display', 'block');
        $('#chat_body').css('display', 'none');
        $('#chat_form').css('display', 'none');
        $('.chat_login').css('display', 'none');
        $('.chat_fullscreen_loader').css('display', 'block');
    }
});
