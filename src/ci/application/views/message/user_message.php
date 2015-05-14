<div class="newpost-wrap">
    <form id="frmUserMessage">
        <div class="form-group">
            <textarea class="form-control" id="txtUserMessage"rows="3"></textarea>
        </div>
        <div class="form-group pull-right">
            <button class="btn btn-primary btn_<?php echo $senderId ?>" id="btnSendMessage" type="submit">Gởi</button>
        </div>
        <div id="replySuccessfully" style="display: none;"></div>
        <div id="replyError" style="display: none;"></div>
    </form>
</div>