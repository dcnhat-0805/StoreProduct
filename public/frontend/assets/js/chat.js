$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {

    $('#prime').click(function () {
        toggleFab();
    });


    $('.chat').hide();
//Toggle chat and links
    function toggleFab() {
        $('#prime i').toggleClass('fa-commenting-o');
        $('#prime i').toggleClass('fa-times');
        // $('#prime').toggleClass('is-active');
        // $('#prime').toggleClass('is-visible');
        $('#prime').toggleClass('is-float');
        $('.chat').toggleClass('is-visible');
        $('.chat').toggleClass('show');
        $('.fab').toggleClass('is-visible');
        hideChat();
        loadMessage();
    }

    function hideChat() {
        $('#chat_converse').toggleClass('show');
        $('#chat_body').css('display', 'none');
        $('#chat_form').css('display', 'none');
        $('.chat_login').css('display', 'none');
        $('.chat_fullscreen_loader').css('display', 'block');
    }

    $('#fab_send').on('click', function () {
        let message = $('#chatSend').val();

        $.ajax({
            url : '/contact/sendContact',
            dataType : 'JSON',
            type : 'POST',
            data : {
                message : message
            },
            success : function (data) {
                loadMessage();
            },
            error : function (data) {

            }
        });
    });

    function loadMessage() {
        $.ajax({
            url : '/contact/getContact',
            dataType : 'JSON',
            type : 'GET',
            success : function (data) {
                $('#chat_converse').html('');
                $('#chatSend').val('');

                if ($('.chat').hasClass('show')) {
                    $('#chat_converse').append(data);
                }
            },
            error : function (data) {

            }
        });
    }
});
