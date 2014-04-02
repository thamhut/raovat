<?php ob_start();
header('Content-Type:text/html;charset=UTF-8');      if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="title" content="<?php echo isset($meta_title)?$meta_title:'chotam.info - Tổng hợp các tin tức rao vặt, mua bán, tìm kiếm hàng ngày.'; ?>" />
<meta name="keywords" content="<?php echo isset($meta_title)?$meta_title:'chotam.info - Tổng hợp các tin tức rao vặt, mua bán, tìm kiếm hàng ngày.'; ?>" />
<meta name="description" content="<?php echo isset($meta_content)?$meta_content:'Toàn bộ thông tin về rao bán cho thuê hàng hóa, nhà cửa đều được tổng hợp trên trang web.'; ?>" />
<meta name="copyright" content="chotam.info" />
<meta name="author" content="chotam.info" />
<link rel="stylesheet" type="text/css" href="{e base_url()}skin/default/style_home.css"/>
<link rel="stylesheet" type="text/css" href="{e base_url()}skin/default/css/bjqs.css" />
<script type='text/javascript' src='{e base_url()}skin/default/js/jquery-1.8.2.min.js'></script>
<script type='text/javascript' src='{e base_url()}skin/default/js/bjqs-1.3.min.js'></script>
<script type='text/javascript' src='{e base_url()}skin/default/js/common.js'></script>
</head>
<body>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-49239398-1', 'chotam.info');
  ga('send', 'pageview');

</script>
<div>
<div id="header">
	<div class="header">
		<a href="{e base_url();}">
            <img src='{e base_url();}/skin/default/img/icon_header.png' class="logo"/>
        </a>
		<div id="div_form_find">
            <form>
                <input id="input_find" type='text' placeholder="Tìm kiếm rao vặt" name="f_raovat"/>
                <input type="button" onclick="findnews();" id="input_find_sub" value="" />
            </form>
        </div>
        <span>Khu vực : </span>
        <div class="choise_city">
        <?php 
        if(@getCacheUser('city')){
            $city = getCacheUser('city');
        echo $city['name_city'];}
        else echo "Toàn quốc"; ?>
        </div>
        <div id="button_dangtin"><a href="<?php echo base_url('news') ?>">Đăng tin</a></div>
        <div id="show_city" class="show_city leftmenu1">
            <div style="font-size: 13px;padding: 15px;text-align: center;"><a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=0'); ?>">---Toàn quốc---</a></div>
            <ul>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=30'); ?>"><li>Hà Nội</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=11'); ?>"><li>Cao Bằng</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=12'); ?>"><li>Lạng Sơn</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=13'); ?>"><li>Hà Bắc</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=14'); ?>"><li>Quảng Ninh</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=16'); ?>"><li>Hải Phòng</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=17'); ?>"><li>Thái Bình</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=18'); ?>"><li>Nam Định</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=19'); ?>"><li>Phú Thọ</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=20'); ?>"><li>Thái Nguyên</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=21'); ?>"><li>Yên Bái</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=22'); ?>"><li>Tuyên Quang</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=23'); ?>"><li>Hà Giang</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=24'); ?>"><li>Lào Cai</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=25'); ?>"><li>Lai Châu</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=26'); ?>"><li>Sơn La</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=27'); ?>"><li>Điện Biên</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=28'); ?>"><li>Hòa Binh</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=33'); ?>"><li>Hà Tây</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=34'); ?>"><li>Hải Dương</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=35'); ?>"><li>Ninh Bình</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=97'); ?>"><li>Bắc Cạn</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=98'); ?>"><li>Bắc Giang</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=99'); ?>"><li>Bắc Ninh</li></a>
                
            </ul>
            <ul>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=43'); ?>"><li>Đà Nẵng</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=47'); ?>"><li>Đắc Lắc</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=49'); ?>"><li>Lâm Đồng</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=73'); ?>"><li>Quảng Bình</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=74'); ?>"><li>Quảng Trị</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=75'); ?>"><li>Huế</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=76'); ?>"><li>Quảng Ngãi</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=77'); ?>"><li>Bình Định</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=78'); ?>"><li>Phú Yên</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=79'); ?>"><li>Khánh Hòa</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=81'); ?>"><li>Gia Lai</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=82'); ?>"><li>Kon Tum</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=83'); ?>"><li>Sóc Trăng</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=88'); ?>"><li>Vĩnh Phúc</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=89'); ?>"><li>Hưng Yên</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=92'); ?>"><li>Quảng Nam</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=36'); ?>"><li>Thanh Hóa</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=37'); ?>"><li>Nghệ An</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=38'); ?>"><li>Hà Tĩnh</li></a>
            </ul>
            <ul>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=55'); ?>"><li>TP HCM</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=60'); ?>"><li>Đồng Nai</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=61'); ?>"><li>Bình Dương</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=62'); ?>"><li>Long An</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=63'); ?>"><li>Tiền Giang</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=64'); ?>"><li>Vĩnh Long</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=65'); ?>"><li>Cần Thơ</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=66'); ?>"><li>Đồng Tháp</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=67'); ?>"><li>An Giang</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=68'); ?>"><li>Kiên Giang</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=69'); ?>"><li>Cà Mau</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=70'); ?>"><li>Tây Ninh</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=71'); ?>"><li>Bến Tre</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=72'); ?>"><li>Vũng Tàu</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=84'); ?>"><li>Trà Vinh</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=85'); ?>"><li>Ninh Thuận</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=86'); ?>"><li>Bình Thuận</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=93'); ?>"><li>Bình Phước</li></a>
                <a href="<?php echo base_url('home/choise_city?url='.urlencode(getCurrentPageURL()).'&city=94'); ?>"><li>Bạc Liêu</li></a>
                
            </ul>
        </div>
        
        <div class="login">
			<div class="menuItem">
            <?php if(@getCacheUser('user')){
                $user = getCacheUser('user');
                echo "Hi <a id='a_login'>".$user['username']."</a> | <a href='".base_url('logout')."'>Logout</a>";}else{?>
				<a id="a_login">Đăng nhập</a> | 
                <a href="<?php echo base_url("user/register"); ?>">Đăng kí</a>
            <?php }?>
			</div>
            
            <div id="frmlogin" class="register repad reborR">
            <div id="parrow_login">
                
            </div>
            <?php if(@getCacheUser('user')){ ?>
                <img style="margin: 0 32px;" src="<?php echo base_url(); ?>skin/default/img/users.png" width="138px" />
                <ul class="">
                    <li><a class="remarL" href="<?php echo base_url(); ?>user/updateinfo" >Cập nhật tài khoản</a></li>
                    <li><a class="remarL" href="<?php echo base_url(); ?>user/updatepass">Thay đổi mật khẩu</a></li>
                    <li><a class="remarL" href="<?php echo base_url(); ?>news/mynews">Xem tin đăng</a></li>
                </ul>
            <?php }else{?>
                <form action="<?php echo base_url('user/login?url=').urlencode(getCurrentPageURL()) ?>" method="post">
                    <label>Tên đăng nhập:</label>
                    <input type="text" name="username" id="username" />
                    <label>Mật khẩu:</label>
                    <input type="password" name="password" id="password" />
                    <input style="width: 184px;" type="submit" name="submit" id="submit" value="Đăng nhập" />
                    <a class="alignRight" href="<?php echo base_url('user/forgetpass'); ?>">Quên mật khẩu ?</a>
                </form>
            <?php }?>
            </div>
            
            <div>
                
            </div>
		</div>
	</div>
	 
</div>

	