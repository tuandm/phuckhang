var allowSearch = true;
$(function() {
    bindUserMessage();
    bindHighLightCommentBox();
    bindUserLike();
    bindUserCommentTextArea();
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
                    bindHighLightCommentBox();
                    bindUserLike();
                    bindUserCommentTextArea();
                    me.attr('disabled', false);
                } else {
                    me.attr('disabled', false);
                    $('#userStatusError').html(result.result);
                    $('#userStatusError').show();
                }
                $("#user-status-refresh").hide();
                $(this).attr('disabled', false);
            }
        });
        return false;
    });
});

$(function() {
    $("#btnPostGroupStatus").click(function() {
        $(this).attr('disabled', true);
        var groupId = $('.groupStatus').attr('id');
        var groupStatus = $('#txtGroupStatus').val();
        var me = $(this);
        $.ajax({
            url: '/social-group-status/',
            type: 'POST',
            data: {
                act: 'ajax',
                callback: 'postGroupStatus',
                txtGroupStatus: groupStatus,
                groupId: groupId
            },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    $('#txtGroupStatus').val('');
                    $('#groupStatusError').hide();
                    $('#user_status_separate').after(result.result).fadeIn('slow');
                    me.attr('disabled', false);
                } else {
                    me.attr('disabled', false);
                    $('#groupStatusError').html(result.result);
                    $('#groupStatusError').show();
                }
                $(this).attr('disabled', false);
            }
        });
        return false;
    });
});

/**
 * Off click highlight Comment Box
 */
function bindHighLightCommentBox() {
    $('.user-comment').off('click').on('click', function() {
        var postId = $(this).attr('id');
        $("." + postId).find('textarea').focus();
        return false;
    });
}

/**
 * Off click like/unlike event then on again
 */
function bindUserLike() {
    $('.user-like').off('click').on('click', function () {
        var me = $(this).parent();
        var achorId = $(this).attr('id');
        var tmp = achorId.split('_');
        var postId = tmp[1];
        var referenceType = 'post';
        var likeError = me.find('#likeError');
        console.log(likeError);
        if ($(this).hasClass('like-type-status')) {
            referenceType = 'status';
        }
        $.ajax({
            url: '/social-homepage/',
            type: 'POST',
            data: {
                act: 'ajax',
                callback: 'likeComment',
                postId: postId,
                type: referenceType
            },
            success: function (response) {
                var result = JSON.parse(response);
                if (result.success) {
                    $('.social-user-like_' + postId).parent().html(result.result);
                    likeError.hide();
                    bindUserLike();
                    bindHighLightCommentBox();
                } else {
                    likeError.html(result.result);
                }
            }
        });
        return false;
    });
}

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

$("#search").keyup(function() {
    if (allowSearch) {
        allowSearch = false;
        $.ajax({
            type: "post",
            url: "/social-user-friends/",
            cache: false,
            data:
            {
                act: 'ajax',
                callback: 'search',
                search: $("#search").val()
            },
            success: function(response) {
                var results = JSON.parse(response);
                if (results.success) {
                    $('#finalResult').html(results.result);
                } else {
                    $('#finalResult').html($('<li/>').text("No Data Found"));
                }
                allowSearch = true;
            },
            error: function() {
                alert('Error while request..');
            }
        });
    }
    return false;
});

function onUserLikeList()
{
    $('.numlike').tooltip();
}

function bindUserMessage() {
        if ($('#messageTab').is('.active')) {
            $('.userMessage').unbind('keydown').keydown(function (event) {
                if (event.keyCode == 13 && !event.shiftKey) {
                    var userMessage = $(this).val();
                    console.log(userMessage);
                    var textareaId = $(this).attr('id');
                    var tmp = textareaId.split('_');
                    var receiverId = tmp[1];
                    var messageError = $(this).parent().find('.userMessageError');
                    var messageSuccess = $(this).parent().find('.userMessageSuccess');
                    var me = $(this);
                    $.ajax({
                        url: '/social-user-message/',
                        type: 'POST',
                        data: {
                            act: 'ajax',
                            callback: 'sendMessage',
                            txtUserMessage: userMessage,
                            receiverId: receiverId
                        },
                        success: function (response) {
                            var result = JSON.parse(response);
                            if (result.success) {
                                me.val('');
                                messageError.hide();
                                messageSuccess.html(result.result);
                                bindUserMessage();
                            } else {
                                messageError.html(result.result);
                            }
                            messageError.fadeIn();
                        }
                    });
                    return false;
                }
            });
        }
}
