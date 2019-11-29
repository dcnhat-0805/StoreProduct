$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {

    function loadCommentOfUser(productId, userId) {
        $.ajax({
            url : '/admin/comment/detail',
            dataType : 'JSON',
            type : 'GET',
            data : {
                product_id : productId,
                user_id : userId,
            },
            success : function (data) {
                $('.sop__box-comment').html(data);
            }
        });
    }

    function resetFormRepComment() {
        $('.form__rep__comment')[0].reset();
        $('.btn__reply-comment').prop('disabled', false);
    }

    $('#replyComment').on('show.bs.modal', function (e) {
        let productId = $(e.relatedTarget).data('product_id');
        let userId = $(e.relatedTarget).data('user_id');
        let message = $(e.relatedTarget).data('message');
        let name = $(e.relatedTarget).data('name');

        $('.title__name').text(name);
        loadCommentOfUser(productId, userId);
    });

    $('#replyComment').on('hide.bs.modal', function () {
        $('.sop__box-comment').html('');
    });

    $('.form__rep__comment').hide();
    $(document).on('click', '.btn__reply__comment', function () {
        $('.form__rep__comment').show();
        let comment_id = $(this).data('id');
        let user_id = $(this).data('user_id');
        let product_id = $(this).data('product_id');
        $('.rep__comment__id').val('');
        $('.comment__reply').val('');

        $('.comment__id').val(comment_id);
        $('.user__id').val(user_id);
        $('.product__id').val(product_id);
    });
    $(document).on('click', '.btn__cancel__comment', function () {
        $('.form__rep__comment').hide();
        $('.comment__id').val('');
        $('.user__id').val('');
        $('.product__id').val('');
        $('.rep__comment__id').val('');
        $('.comment__reply').val('');
        resetFormRepComment();
    });

    $('.error__comment_reply').hide();
    $(document).on('click', '.btn__reply-comment', function () {
        let formData =  $('.form__rep__comment').serialize();
        let comment_id = $('.comment__id').val();
        let comment_reply = $('.comment__reply').val();
        let user_id = $('.user__id').val();
        let product_id = $('.product__id').val();
        $(this).prop('disabled', true);

        if (!comment_reply) {
            resetFormRepComment();
            $('.error__comment_reply').show();
            return;
        }
        $.ajax({
            url : '/admin/comment/reply',
            dataType : 'JSON',
            type : 'POST',
            data : formData,
            beforeSend : function() {
                $('.error__comment_reply').hide();
            },
            success : function (data) {
                if (data.success === 'yes') {
                    resetFormRepComment();
                    loadCommentOfUser(product_id, user_id);
                }
            }
        });
    });

    $(document).on('click', '.btn__remove__comment', function () {
        let comment_id = $(this).data('id');
        let user_id = $(this).data('user_id');
        let product_id = $(this).data('product_id');
        $(this).prop('disabled', true);

        let r = window.confirm('Are you sure you want to delete the comment ?');
        if (r == true) {
            $.ajax({
                url : '/admin/comment/delete/' + comment_id,
                dataType : 'JSON',
                type : 'POST',
                beforeSend : function() {
                    $('.error__comment_reply').hide();
                },
                success : function (data) {
                    if (data.success === 'yes') {
                        resetFormRepComment();
                        loadCommentOfUser(product_id, user_id);
                    }
                }
            });
        } else {
            $(this).prop('disabled', false);
        }
    });

    //update
    $(document).on('click', '.btn__edit__comment__admin', function () {
        $('.form__rep__comment').show();
        let id = $(this).data('id');
        let comment_id = $(this).data('comment_id');
        let user_id = $(this).data('user_id');
        let product_id = $(this).data('product_id');
        let comment_reply = $(this).data('comment_reply');
        if (comment_reply) {
            $('.comment__reply').val(comment_reply);
        }

        $('.rep__comment__id').val(id);
        $('.comment__id').val(comment_id);
        $('.user__id').val(user_id);
        $('.product__id').val(product_id);
    });

    $(document).on('click', '.btn__remove__comment__admin', function () {
        let comment_id = $(this).data('id');
        let user_id = $(this).data('user_id');
        let product_id = $(this).data('product_id');
        $(this).prop('disabled', true);

        let r = window.confirm('Are you sure you want to delete the reply comment ?');
        if (r == true) {
            $.ajax({
                url : '/admin/comment/deleteReply/' + comment_id,
                dataType : 'JSON',
                type : 'POST',
                beforeSend : function() {
                    $('.error__comment_reply').hide();
                },
                success : function (data) {
                    if (data.success === 'yes') {
                        resetFormRepComment();
                        loadCommentOfUser(product_id, user_id);
                    }
                }
            });
        } else {
            $(this).prop('disabled', false);
        }
    });
});
