<div class="newpost-wrap">
    <form id="frmAddGroupStatus" method="POST">
        <div class="form-group groupStatus" id="<?php echo $groupId?>" >
            <textarea class="form-control " name="txtGroupStatus" id="txtGroupStatus" rows="3"></textarea>
        </div>
        <div class="form-group pull-right">
            <button class="btn btn-primary" name="btnPostGroupStatus" id="btnPostGroupStatus" type="submit">Thông Báo</button>
        </div>
        <div id="groupStatusError" style="display: none;"></div>
    </form>
</div>