$(function() {
    $("#btnPostStatus").click(function() {
        $(this).attr('disabled', true);
        $("#user-status-refresh").show();
        var userStatus = $('#txtUserStatus').val();
        var me = $(this);
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
                    $('#user_status_separate').after(result.result).fadeIn('slow');
                    bindUserCommentTextArea();
                    me.attr('disabled', false);
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
    bindUserCommentTextArea();
});

$(function(){
    $('.user-comment').click(function() {
        var postId = $(this).attr('id');
        $("." + postId).find('textarea').focus();
        return false;
    });
});

$(function(){
    $('.user-like').click(function() {
        console.debug($(this).parent().find('#like'));
        $(this).parent().find('#like').toggleClass('fa fa-thumbs-o-up fa fa-thumbs-o-down');
        return false;
    });
});

/**
 * Unbind keydown event in comment textbox then binding again.
 */
function bindUserCommentTextArea()
{
    $('.userCommentPost').unbind('keydown').keydown(function(event) {
        if (event.keyCode == 13 && !event.shiftKey) {
            var userComment = $(this).val();
            var textareaId = $(this).attr('id');
            var tmp = textareaId.split('_');
            var postId = tmp[1];
            var referenceType = 'post';
            if ($(this).hasClass('type-status')) {
                referenceType = 'status';
            }
            var commentError = $(this).parent().find('.userCommentError');
            var me = $(this);
            $.ajax({
                url: '/social-homepage/',
                type: 'POST',
                data: {
                    act: 'ajax',
                    callback: 'postComment',
                    txtUserComment: userComment,
                    postId: postId,
                    type: referenceType
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        me.val('');
                        commentError.hide();
                        $('div.comment-post-' + postId).before(result.result).fadeIn('slow');
                    } else {
                        commentError.html(result.result);
                    }
                    commentError.fadeIn();
                }
            });
            return false;
        }
    });
}

