<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 2/2/15
 * Time: 8:09 PM
 */
?>

<form name="edittag" id="edittag" method="post" action="" class="validate">
    <table class="form-table">
        <tbody>
            <tr class="form-field form-required term-name-wrap">
                <th scope="row"><label for="name">Name</label></th>
                <td><input name="name" id="name" value="<?php echo $groups[0]['name'];?>" size="40" aria-required="true" type="text">
            </tr>
            <tr class="form-field term-slug-wrap">
                <th scope="row"><label for="slug">Slug</label></th>
                <td><input name="slug" id="slug" value="<?php echo $groups[0]['slug'];?>" size="40" type="text">
            </tr>
            <tr class="form-field term-description-wrap">
                <th scope="row"><label for="description">Description</label></th>
                <td><textarea name="description" id="description" rows="5" cols="50" class="large-text"><?php echo $groups[0]['description'];?></textarea>
            </tr>
        </tbody>
    </table>
    <input name="id" id="id" value="<?php echo $groups[0]['term_id'];?>" size="40" aria-required="true" type="hidden">
    <input type="hidden" id="action" name="act" value="editGroup"><br>
    <p class="submit"><input name="update" id="submit" class="button button-primary" value="Update" type="submit"></p>
</form>