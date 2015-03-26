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

    $(".show-more a").on("click", function() {
        var $this = $(this);
        var $content = $this.parent().prev("div.content");
        var linkText = $this.text().toUpperCase();
        console.log($content);

        if(linkText === "SHOW MORE"){
            linkText = "Show less";
            $content.switchClass("hideContent", "showContent", 400);
        } else {
            linkText = "Show more";
            $content.switchClass("showContent", "hideContent", 400);
        };

        $this.text(linkText);
    });
});

