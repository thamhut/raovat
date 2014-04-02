<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="box_container">
    <div class="topbanner_category">
    </div>
    <div style="margin: 20px auto 10px;width:665px;">
    </div>
    <?php $this->load->view('/menu_view'); ?>
    
    <div class="box_data">
        <div class="register">
        <?php if(!isset($done)){ ?>
            <form action="" method="post">
                <table width=100% class="input">
                <tr>
                    <td class="alignCenter"><h3>Lấy lại mật khẩu</h3></td>
                </tr>
                <?php if(isset($err)) echo '<p style="color:red">'.$err.'</p>'; ?>
                <tr>
                    <td class="alignLeft"><label>Nhập tên đăng nhập:</label></td>
                </tr>
                 <tr>
                    <td class="alignLeft"><input value="<?php echo isset($set['username'])?$set['username']:''; ?>" class="<?php echo (isset($errUser)&&($errUser!=''))?'error_input':''; ?>" type="text" width="100px" name="username" id="username" /><p class="errName <?php echo (isset($errUser)&&($errUser!=''))?'error_put':''; ?>"><?php echo (isset($errUser)&&($errUser!=''))?$errUser:''; ?></p></td>
                </tr>
                <tr>
                    <td class="alignLeft"><label>Nhập mật khẩu mới:</label></td>
                </tr>
                <tr>
                    <td class="alignLeft"><input value="<?php echo isset($_POST['password'])?$_POST['password']:''; ?>" type="password" class="<?php echo (isset($errPass)&&($errPass!=''))?'error_input':''; ?>" width="100px" name="pass2" id="password" /><p class="errPass <?php echo (isset($errPass)&&($errPass!=''))?'error_put':''; ?>"><?php echo (isset($errPass)&&($errPass!=''))?$errPass:''; ?></p></td>
                </tr>
                <tr>
                    <td class="alignLeft"><label>Nhập lại mật khẩu:</label></td>
                </tr>
                <tr>
                    <td class="alignLeft"><input value="<?php echo isset($_POST['repassword'])?$_POST['repassword']:''; ?>" class="<?php echo (isset($errRePass)&&($errRePass!=''))?'error_input':''; ?>" type="password" width="100px" name="repassword" id="repassword" /><p class="errRePass <?php echo (isset($errRePass)&&($errRePass!=''))?'error_put':''; ?>"><?php echo (isset($errRePass)&&($errRePass!=''))?$errRePass:''; ?></p></td>
                </tr>
                <tr>
                    <td class="alignLeft"><label>Nhập mã xác nhận: </label></td>
                </tr>
                <tr>
                    <td><input class="<?php echo (isset($errCode)&&($errCode!=''))?'error_input':''; ?>" type="text" id="incode" name="incode" /><p class=" <?php echo (isset($errCode)&&($errCode!=''))?'error_put':''; ?>"><?php echo (isset($errCode)&&($errCode!=''))?$errCode:''; ?></p></td>
                </tr>
                <tr>
                    <td class="alignLeft"><input type="submit" width="20px" name="submit" id="submit" value="Thay đổi" /></td>
                </tr>
                </table>
            </form>
            <?php }else echo '<h3><p style="color: #D15B00;padding-top: 50px;text-align: center;">Mật khẩu của bạn đã được thay đổi!</p></h3>';?>
        </div>
    </div>
</div>

<script>
    
</script>