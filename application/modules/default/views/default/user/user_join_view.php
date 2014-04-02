
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
                    <td class="alignCenter"><h3>Đăng kí thành viên</h3></td>
                </tr>
                <tr>
                    <td class="alignLeft"><label>Tên đăng nhập:<span class="error_put">(*)</span></label></td>
                </tr>
                <tr>
                    <td class="alignLeft"><input value="<?php echo isset($set['username'])?$set['username']:''; ?>" class="<?php echo (isset($errUser)&&($errUser!=''))?'error_input':''; ?>" type="text" width="100px" name="username" id="username" /><p class="errName <?php echo (isset($errUser)&&($errUser!=''))?'error_put':''; ?>"><?php echo (isset($errUser)&&($errUser!=''))?$errUser:''; ?></p></td>
                    <input type="text" hidden="" name="namecode" value="<?php echo md5(strtoupper($key)); ?>" />
                </tr>
                <tr>
                    <td class="alignLeft"><label>Mật khẩu: <i>(Mật khẩu từ 6 kí tự trở lên.)<span class="error_put">(*)</span></i></label></td>
                </tr>
                <tr>
                    <td class="alignLeft"><input value="<?php echo isset($_POST['password'])?$_POST['password']:''; ?>" type="password" class="<?php echo (isset($errPass)&&($errPass!=''))?'error_input':''; ?>" width="100px" name="password" id="password" /><p class="errPass <?php echo (isset($errPass)&&($errPass!=''))?'error_put':''; ?>"><?php echo (isset($errPass)&&($errPass!=''))?$errPass:''; ?></p></td>
                </tr>
                <tr>
                    <td class="alignLeft"><label>Nhập lại mật khẩu:<span class="error_put">(*)</span></label></td>
                </tr>
                <tr>
                    <td class="alignLeft"><input value="<?php echo isset($_POST['repassword'])?$_POST['repassword']:''; ?>" class="<?php echo (isset($errRePass)&&($errRePass!=''))?'error_input':''; ?>" type="password" width="100px" name="repassword" id="repassword" /><p class="errRePass <?php echo (isset($errRePass)&&($errRePass!=''))?'error_put':''; ?>"><?php echo (isset($errRePass)&&($errRePass!=''))?$errRePass:''; ?></p></td>
                </tr>
                <tr>
                    <td class="alignLeft"><label>Nhập email:<span class="error_put">(*)</span></label></td>
                </tr>
                <tr>
                    <td class="alignLeft"><input value="<?php echo isset($set['email'])?$set['email']:''; ?>" class="<?php echo (isset($errEmail)&&($errEmail!=''))?'error_input':''; ?>" type="email" width="100px" name="email" id="email" /><p class="errEmail <?php echo (isset($errEmail)&&($errEmail!=''))?'error_put':''; ?>"><?php echo (isset($errEmail)&&($errEmail!=''))?$errEmail:''; ?></p></td>
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
                    <td class="alignLeft"><input type="submit" width="20px" name="submit" id="submit" value="Đăng kí" /></td>
                </tr>
                </table>
            </form>
            <?php }else{echo '<h3><p style="color: #D15B00;padding-top: 50px;text-align: center;">Đăng kí thành công!</p></h3>';}?>
            
        </div>
    </div>
</div>

<script>
    <?php if(isset($done)){ ?>
        setTimeout("location.href = '<?php echo base_url('user/login'); ?>';",500);
    <?php }?>
    /*function showError(s, mess) {
		$('p#errName').remove();
		$(s).after('<p class="error_put" id="errName">'+ mess +'</p>');
	}
    
    function checkValidate() {
		if ($('#username').val() == '') {
			showError('#username','Bạn chưa nhập tên đăng nhập.');
			return false;
		}
        
		var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if ($('#email').val() == '') {
			showError('#email','Bạn chưa nhập địa chỉ email');
			return false;
		} else if ( ! regex.test($('#email').val())) {
			showError('#email','Địa chỉ email không hợp lệ.');
			return false;
		}
        
		if ($('#password').val() == '') {
			showError('#password','Bạn chưa nhập mật khẩu');
			return false;
		}else if($('#password').val().length<6)
        {
            showError('#password','Mật khẩu ít nhất 6 kí tự');
			return false;
        }
        
		if ($('#repassword').val() == '') {
			showError('#repassword','Bạn chưa nhập lại mật khẩu');
			return false;
		}
		else if ($('#repassword').val() != $('#password').val()) {
			showError('#repassword','Nhập lại mật khẩu không đúng.');
			return false;
		}
	}*/
</script>