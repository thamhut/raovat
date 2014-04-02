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
                    <td class="alignCenter"><h3>Đổi mật khẩu</h3></td>
                </tr>
                <tr>
                    <td class="alignLeft"><label>Mật khẩu cũ:<span class="error_put">(*)</span></label></td>
                </tr>
                <tr>
                    <td class="alignLeft"><input value="" class="<?php echo (isset($data['errPass1'])&&($data['errPass1']!=''))?'error_input':''; ?>" type="password" width="100px" name="pass1" id="username" /><p class=" <?php echo (isset($data['errPass1'])&&($data['errPass1']!=''))?'error_put':''; ?>"><?php echo (isset($data['errPass1'])&&($data['errPass1']!=''))?$data['errPass1']:''; ?></p></td>
                </tr>
                <tr>
                    <td class="alignLeft"><label>Mật khẩu mới:<span class="error_put">(*)</span></label></td>
                </tr>
                <tr>
                    <td class="alignLeft"><input value="" class="<?php echo (isset($data['errPass2'])&&($data['errPass2']!=''))?'error_input':''; ?>" type="password" width="100px" name="pass2" id="email" /><p class=" <?php echo (isset($data['errPass2'])&&($data['errPass2']!=''))?'error_put':''; ?>"><?php echo (isset($data['errPass2'])&&($data['errPass2']!=''))?$data['errPass2']:''; ?></p></td>
                </tr>
                <tr>
                    <td class="alignLeft"><label>Nhập lại:<span class="error_put">(*)</span></label></td>
                </tr>
                <tr>
                    <td class="alignLeft"><input value="" class="<?php echo (isset($data['errPass3'])&&($data['errPass3']!=''))?'error_input':''; ?>" type="password" width="100px" name="pass3" id="email" /><p class=" <?php echo (isset($data['errPass3'])&&($data['errPass3']!=''))?'error_put':''; ?>"><?php echo (isset($data['errPass3'])&&($data['errPass3']!=''))?$data['errPass3']:''; ?></p></td>
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