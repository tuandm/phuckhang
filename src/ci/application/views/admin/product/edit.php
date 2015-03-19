<?php
    $this->load->helper('form');
?>
<h2>EDIT PRODUCT</h2>
<form name="edit-product" id="edit-product" method="post" action="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=landbook-products&amp;noheader=true" class="validate" >
    <table class="form-table">
        <tbody>
            <tr class="form-field form-required term-name-wrap">
                <th scope="row"><label for="product-code">Code<span style="color: #ff0000">(*)</span></label></th>
                <td><input name="product-code" id="product-code" value="<?php echo $product->code; ?>" size="40" aria-required="true" type="text" required>
                <span id="validation" style="color:red"><?php echo form_error('product-code'); ?></span>
            </tr>
            <tr class="form-field form-required term-name-wrap">
                <th scope="row"><label for="price">Price<span style="color: #ff0000">(*)</span></label></th>
                <td><input name="price" id="price" value="<?php echo $product->price; ?>" size="40" aria-required="true" type="text" required>
                <span id="validation" style="color:red"><?php echo form_error('price'); ?></span>
            </tr>
            <tr class="form-field form-required term-name-wrap">
                <th scope="row"><label for="project-name">Project<span style="color: #ff0000">(*)</span></label></th>
                <td><?php echo form_dropdown('project-name', $projects ,$projectName); ?></td>
            </tr>
                <tr class="form-field term-slug-wrap">
                <th scope="row"><label for="post-content">Status<span style="color: #ff0000">(*)</span></label></th>
                <td><?php echo form_dropdown('status', $statusNames ,$product->status); ?></td>
            </tr>
        </tbody>
    </table>
    <input name="product-id" id="product-id" value="<?php echo $product->lb_product_id; ?>" size="40" aria-required="true" type="hidden">
    <input type="hidden" id="action" name="act" value="Update"><br>
    <p class="submit"><input name="update" id="submit" class="button button-primary" value="Update" type="submit"></p>
</form>