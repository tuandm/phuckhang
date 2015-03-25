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
                if (response == 'OK') {
                    $("#user-status-refresh").hide();
                    $(this).attr('disabled', false);
                    $('#txtUserStatus').val('');
                }
            }
        });
        return false;
    });
});