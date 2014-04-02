
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="box_container">
    <div class="topbanner_category">
    </div>
    <div style="margin: 20px auto 10px;width:665px;">
    </div>
    <?php $this->load->view('/menu_view'); ?>
    
    <div class="box_data">
        <div class="register">
        <?php if(!isset($send)){ ?>
            <form action="" method="post">
                <table width=100% class="input">
                <tr>
                    <td class="alignCenter"><h3>Gửi xác nhận</h3></td>
                </tr>
                <?php echo $errUser!=''?'<tr><td><p style="color:red;">'.$errUser.'</p><td></tr>':''; ?>
                <tr>
                    <td class="alignLeft"><label>Nhập tên đăng nhập:</label></td>
                </tr>
                <tr>
                    <td class="alignLeft"><input value="" class="" type="text" width="100px" name="username" id="username" /></td>
                </tr>
                <tr>
                    <td class="alignLeft"><label>Nhập email: </label></td>
                </tr>
                <tr>
                    <td class="alignLeft"><input value="" type="email" class="" width="100px" name="email" id="email" /></td>
                </tr>
                <tr>
                    <td class="alignLeft"><input type="submit" width="20px" name="submit" id="submit" value="Gửi" /></td>
                </tr>
                </table>
            </form>
            <?php }else echo '<h3><p style="color: #D15B00;padding-top: 50px;text-align: center;">Email xác nhận đã gửi tới email của bạn!</p></h3>';?>
        </div>
    </div>
</div>

<script>
</script>