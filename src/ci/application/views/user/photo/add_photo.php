<?php if (isset($userId) && ($userId == $photos[0]['user_id'])) : ?>
<form method="post" action="" enctype="multipart/form-data" />
<div class="fileUpload btn btn-primary">
    <span>Up hình ảnh mới</span>
    <input id="uploadBtn" type="file" class="upload" name="myImages"/>
</div>
<div class="col-xs-4 col-sm-4">
    <input type="text" name="txtDescription" id="uploadFile" class="form-control" required>
</div>
    <input type="submit" placeholder="Upload" value="Upload">
    <input type="hidden" id="action" name="act" value="addImages">
</form>
<?php endif;?>

<script>
    document.getElementById("uploadBtn").onchange = function () {
        document.getElementById("uploadFile").value = this.value;
    };
</script>