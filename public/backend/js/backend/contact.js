$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {

    function loadContactOfUser(userId) {
        $.ajax({
            url : '/admin/contact/detail',
            dataType : 'JSON',
            type : 'GET',
            data : {
                user_id : userId,
            },
            success : function (data) {
                $('.sop__box-comment').html(data['contact']);
                $('.chat__comment').animate({
                    scrollTop: Math.pow($('.message').length ? $('.message').length : data['countItem'], 3)
                }, 1500);
            }
        });
    }

    function resetFormRepComment() {
        $('.form__rep__contact')[0].reset();
        $('.btn__reply-contact').prop('disabled', false);
    }

    $('#replyContact').on('show.bs.modal', function (e) {
        let productId = $(e.relatedTarget).data('product_id');
        let userId = $(e.relatedTarget).data('user_id');
        let message = $(e.relatedTarget).data('message');
        let name = $(e.relatedTarget).data('name');

        $('.user__id').val(userId);

        $('.title__name').text(name);
        loadContactOfUser(userId);
    });

    $('#replyContact').on('hide.bs.modal', function () {
        $('.sop__box-comment').html('');
        // $('.form__rep__contact').hide();
        $('.comment__id').val('');
        $('.user__id').val('');
        $('.product__id').val('');
        $('.rep__comment__id').val('');
        $('.comment__reply').val('');
        resetFormRepComment();
    });

    $('.form__rep__contact').show();
    // $(document).on('click', '.btn__reply__comment', function () {
    //     $('.form__rep__contact').show();
    //     let comment_id = $(this).data('id');
    //     let user_id = $(this).data('user_id');
    //     let product_id = $(this).data('product_id');
    //     $('.rep__comment__id').val('');
    //     $('.comment__reply').val('');
    //
    //     $('.comment__id').val(comment_id);
    //     $('.user__id').val(user_id);
    //     $('.product__id').val(product_id);
    // });
    // $(document).on('click', '.btn__cancel__contact', function () {
    //     $('.form__rep__contact').hide();
    //     $('.comment__id').val('');
    //     $('.user__id').val('');
    //     $('.product__id').val('');
    //     $('.rep__comment__id').val('');
    //     $('.comment__reply').val('');
    //     resetFormRepComment();
    // });

    $('.error__contact_reply').hide();
    $(document).on('click', '.btn__reply-contact', function () {
        let formData =  $('.form__rep__contact').serialize();
        let message = $('.contact__reply').val();
        let user_id = $('.user__id').val();
        $(this).prop('disabled', true);

        if (!message) {
            resetFormRepComment();
            $('.error__contact_reply').show();
            return;
        }
        $.ajax({
            url : '/admin/contact/reply',
            dataType : 'JSON',
            type : 'POST',
            data : formData,
            beforeSend : function() {
                $('.error__contact_reply').hide();
            },
            success : function (data) {
                resetFormRepComment();
                loadContactOfUser(user_id);
            }
        });
    });
    //
    // $(document).on('click', '.btn__remove__comment', function () {
    //     let comment_id = $(this).data('id');
    //     let user_id = $(this).data('user_id');
    //     let product_id = $(this).data('product_id');
    //     $(this).prop('disabled', true);
    //
    //     let r = window.confirm('Are you sure you want to delete the comment ?');
    //     if (r == true) {
    //         $.ajax({
    //             url : '/admin/comment/delete/' + comment_id,
    //             dataType : 'JSON',
    //             type : 'POST',
    //             beforeSend : function() {
    //                 $('.error__contact_reply').hide();
    //             },
    //             success : function (data) {
    //                 if (data.success === 'yes') {
    //                     resetFormRepComment();
    //                     loadContactOfUser(user_id);
    //                 }
    //             }
    //         });
    //     } else {
    //         $(this).prop('disabled', false);
    //     }
    // });
    //
    // //update
    // $(document).on('click', '.btn__edit__comment__admin', function () {
    //     $('.form__rep__contact').show();
    //     let id = $(this).data('id');
    //     let comment_id = $(this).data('comment_id');
    //     let user_id = $(this).data('user_id');
    //     let product_id = $(this).data('product_id');
    //     let comment_reply = $(this).data('comment_reply');
    //     if (comment_reply) {
    //         $('.comment__reply').val(comment_reply);
    //     }
    //
    //     $('.rep__comment__id').val(id);
    //     $('.comment__id').val(comment_id);
    //     $('.user__id').val(user_id);
    //     $('.product__id').val(product_id);
    // });
    //
    // $(document).on('click', '.btn__remove__comment__admin', function () {
    //     let comment_id = $(this).data('id');
    //     let user_id = $(this).data('user_id');
    //     let product_id = $(this).data('product_id');
    //     $(this).prop('disabled', true);
    //
    //     let r = window.confirm('Are you sure you want to delete the reply comment ?');
    //     if (r == true) {
    //         $.ajax({
    //             url : '/admin/comment/deleteReply/' + comment_id,
    //             dataType : 'JSON',
    //             type : 'POST',
    //             beforeSend : function() {
    //                 $('.error__contact_reply').hide();
    //             },
    //             success : function (data) {
    //                 if (data.success === 'yes') {
    //                     resetFormRepComment();
    //                     loadContactOfUser(user_id);
    //                 }
    //             }
    //         });
    //     } else {
    //         $(this).prop('disabled', false);
    //     }
    // });
});
