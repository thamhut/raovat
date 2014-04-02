<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="box_container register" style="top: 60px;">
<form method="post" >
<?php foreach($lstcate as $cate){ ?>

    <label>Id</label><input type="text" name="id[]" value="<?php echo $cate['id']; ?>" />
    <label>Id level</label><input type="text" name="id_level[]" value="<?php echo $cate['id_level']; ?>" />
    <label>Id</label><input type="text" name="name[]" value="<?php echo $cate['name']; ?>" />
    <label>Id</label><input type="text" name="name1[]" value="<?php echo $cate['name1']; ?>" />
    <br />
    <br />
<?php }?>
<input type="submit" name="submit" value="Cập nhật" />
</form>
</div>