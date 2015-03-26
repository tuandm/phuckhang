$(function() {
    $("#btnPostStatus").click(function() {
        $(this).attr('disabled', true);
        $("#user-status-refresh").show();
        var userStatus = $('#txtUserStatus').val();
        $.ajax({
            url: '/social-homepage/',
            type: 'POST',
            data: {
                act: 'ajax',
                callback: 'postStatus',
                txtUserStatus: userStatus
            },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    $('#txtUserStatus').val('');
                    $('#userStatusError').hide();
                } else {
                    $('#userStatusError').html(result.result);
                    $('#userStatusError').show();
                }
                $("#user-status-refresh").hide();
                $(this).attr('disabled', false);
            }
        });
        return false;
    });

    $('.userComment').keydown(function(event) {
        if (event.keyCode == 13 && !event.shiftKey) {
            var userComment = $(this).val();
            var textareaId = $(this).attr('id');
            var tmp = textareaId.split('_');
            var postId = tmp[1];
            var commentError = $(this).parent().find('.userCommentError');
            var me = $(this);
            $.ajax({
                url: '/social-homepage/',
                type: 'POST',
                data: {
                    act: 'ajax',
                    callback: 'postComment',
                    txtUserComment: userComment,
                    postId: postId
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        me.val('');
                        commentError.hide();
                        $('div.comment-text').before(result.result).fadeIn('slow');
                    } else {
                        commentError.html(result.result);
                        commentError.fadeIn();
                    }
                }
            });
            return false;
        }
    });
});

