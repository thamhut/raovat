
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="box_container">
    <div class="topbanner_category">
    </div>
    <div style="margin: 20px auto 10px;width:665px;">
    </div>
    <?php $this->load->view('/menu_view'); ?>
    
    <div class="box_data">
        <div class="register">
            <form action="" method="post">
                <table width=100% class="input">
                <tr>
                    <td class="alignCenter"><h3>Đăng nhập</h3></td>
                </tr>
                <?php echo $errUser!=''?'<tr><td><p style="color:red;">'.$errUser.'</p><td></tr>':''; ?>
                <tr>
                    <td class="alignLeft"><label>Tên đăng nhập:</label></td>
                </tr>
                <tr>
                    <td class="alignLeft"><input value="" class="" type="text" width="100px" name="username" id="username" /></td>
                </tr>
                <tr>
                    <td class="alignLeft"><label>Mật khẩu: </label></td>
                </tr>
                <tr>
                    <td class="alignLeft"><input value="" type="password" class="" width="100px" name="password" id="password" /></td>
                </tr>
                <tr>
                    <td class="alignLeft"><input type="submit" width="20px" name="submit" id="submit" value="Đăng nhập" /></td>
                </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<script>
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