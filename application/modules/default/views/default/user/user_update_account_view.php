
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="box_container">
    <div class="topbanner_category">
    </div>
    <div style="margin: 20px auto 10px;width:665px;">
    </div>
    <?php $this->load->view('/menu_view'); ?>
    
    <div class="box_data">
        <div class="register">
        <?php if(!isset($done)){?>
            <form action="" method="post">
                <table width=100% class="input">
                <tr>
                    <td class="alignCenter"><h3>Thay đổi thông tin</h3></td>
                </tr>
                <tr>
                    <td class="alignLeft"><label>Tên đăng nhập:<span class="error_put">(*)</span></label></td>
                </tr>
                <tr>
                    <td class="alignLeft"><input value="<?php echo $info['username']; ?>" class="<?php echo (isset($errUser)&&($errUser!=''))?'error_input':''; ?>" type="text" width="100px" name="username" id="username" /><p class="errName <?php echo (isset($errUser)&&($errUser!=''))?'error_put':''; ?>"><?php echo (isset($errUser)&&($errUser!=''))?$errUser:''; ?></p></td>
                    <input type="text" hidden="" name="namecode" value="<?php echo md5(strtoupper($key)); ?>" />
                </tr>
                <tr>
                    <td class="alignLeft"><label>Nhập email:<span class="error_put">(*)</span></label></td>
                </tr>
                <tr>
                    <td class="alignLeft"><input value="<?php echo $info['email']; ?>" class="<?php echo (isset($errEmail)&&($errEmail!=''))?'error_input':''; ?>" type="email" width="100px" name="email" id="email" /><p class="errEmail <?php echo (isset($errEmail)&&($errEmail!=''))?'error_put':''; ?>"><?php echo (isset($errEmail)&&($errEmail!=''))?$errEmail:''; ?></p></td>
                </tr>
                <tr>
                    <td class="alignLeft" style="padding-bottom: 0 !important; margin-bottom: 0 !important;"><label><span class="ver_top">Nhập mã sau vào ô dưới: </span>
                    <?php foreach($code as $item){ ?>
                        <img width="15" src="<?php echo base_url('').'skin/default/xacnhancp/'.getRealIPAddress().'/'.$item.'.png'; ?>" />
                    <?php } ?>
                    <span class="error_put ver_top">(*)</span>
                    </label></td>
                </tr>
                <tr>
                    <td><input class="<?php echo (isset($errCode)&&($errCode!=''))?'error_input':''; ?>" type="text" id="incode" name="incode" /><p class=" <?php echo (isset($errCode)&&($errCode!=''))?'error_put':''; ?>"><?php echo (isset($errCode)&&($errCode!=''))?$errCode:''; ?></p></td>
                </tr>
                <tr>
                    <td class="alignLeft"></td>
                </tr>
                <tr>
                    <td class="alignLeft"><input type="submit" width="20px" name="submit" id="submit" value="Cập nhật" /></td>
                </tr>
                </table>
            </form>
            <?php }else{?>
            <h3><p style="color: #D15B00;padding-top: 50px;text-align: center;">Cập nhật thành công!</p></h3>
            <?php } ?>
        </div>
    </div>
</div>

<script type="text/JavaScript">
    <?php if(isset($done)){ ?>
        setTimeout("location.href = '<?php echo base_url(); ?>';",500);
    <?php }?>
</script>