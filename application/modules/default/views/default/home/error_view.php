<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script>
    jQuery(document).ready(function($) {

      $('#banner-fade').bjqs({
        height      : 245,
        width       : 750,
        animduration    : 2000,      // length of transition
        animspeed       : 5500,
        responsive  : true
      });
      $('#banner-fade').css('overflow','hidden')
      $(".bjqs-controls").remove();
      $(".h-centered").remove();

    });
</script>
<?php
//print_r($cate);
?>
<div class="box_container">
    <div class="topbanner">
        <div id="banner-fade">
            <ul class="bjqs">
              <li><img src="{e base_url()}skin/default/img/banner1.png" /></li>
              <li><img src="{e base_url()}skin/default/img/banner2.png" /></li>
              <li><img src="{e base_url()}skin/default/img/banner3.png" /></li>
            </ul>
        </div>
    </div>
    <div class="_news">
        <h3>Tin rao mới đăng</h3>
        
    </div>
    <div class="clear"></div>
    <?php $this->load->view('/menu_view'); ?>
    <div class="box_data remarT" >
        <div style="margin: 10px auto;width: 200px;"><?php echo $error; ?></div>
    </div>
</div>