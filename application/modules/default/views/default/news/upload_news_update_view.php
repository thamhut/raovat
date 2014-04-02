<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript" src="<?php echo base_url()?>skin/default/js/tiny_mce.js"></script>
<div class="box_container">
    <div class="topbanner_category">
    </div>
    <div style="margin: 20px auto 10px;width:665px;">
    </div>
    <?php $this->load->view('/menu_view'); ?>
    <div id="lst_cate" class="box_data" style="position: relative; display: none;">
        <div id="left_news">
        <h3 style="font-size: 22px; font-weight:600; margin:-115px 0;">Đăng tin miễn phí</h3>
        </div>
        <div id="cate_news1">
            <h3 class="cate_news_h3" >Chọn danh mục</h3>
            <div style="">
                <ul>
                <?php
                $lstCate = $this->home_model->getall_category();
                foreach($lstCate as $icate)
                {
                    if($icate['id']==0){
                ?>
                    <li id="newsli_<?php echo $icate['id_level']; ?>"><?php echo $icate['name']; ?></li>
                <?php }}?>
                </ul>
            </div>
        </div>
        
        <div class="praw_right_new">
        </div>
        
        <?php 
        foreach($lstCate as $icate)
        {
            if($icate['id']==0){
        ?>
            <div id="leftnews2-newsli_<?php echo $icate['id_level']; ?>" class="cate_news2">
                <h3 id="cate2_news_h3" class="cate_news_h3">Danh mục phụ</h3>
                <div style="">
                <ul>
                <?php
                foreach($lstCate as $icate2)
                {
                    if($icate2['id']==$icate['id_level'])
                    {
                        echo '<li onclick="choisecate('.$icate2['id_level'].');" id="_'.$icate2['id_level'].'"><a>'.$icate2['name'].'</a></li>';
                    }
                }
                ?>
                </ul>
                </div>
            </div>
        <?php
        }}
        ?>
    </div>
    
    <div id="input_data_new" class="register" >
    <?php 
    if((isset($msg['errTitle'])&&($msg['errTitle']!=''))){
    ?>
    <p class="errName error_put"><?php echo $msg['errTitle']; ?></p>
    <?php } ?>
    <?php 
    if((isset($msg['errCode'])&&($msg['errCode']!=''))){
    ?>
    <p class="errName error_put"><?php echo $msg['errCode']; ?></p>
    <?php } ?>
        <h3>Hoàn thành các thông tin đăng</h3>
        <form action="" method="post" enctype="multipart/form-data">
            <table id="tb_news">
                <tr>
                    <td>
                        <label>Chuyên mục: <span id="span_choise_cate"><?php echo $cate['cate1']; ?></span> > <span id="span_choise_lvcate"><?php echo $cate['cate2']; ?></span></label>
                        <input type="text" name="cate" id="input_choise_cate" hidden="" value="" /><input type="text" name="catelv" id="input_choise_lvcate" hidden="" value="<?php echo $content['id_category']; ?>" />
                        <input type="text" hidden="" name="namecode" value="<?php echo md5(strtoupper($key)); ?>" />
                    <td>
                </tr>
                
                <tr>
                    <td><a style="color: blue;" onclick="changecate();">Đổi chuyên mục</a></td>
                </tr>
                
                <tr>
                    <td>
                        <label>Tiêu đề tin: <span class="error_put">(*)</span></label>
                    <td>
                </tr>
                <tr>
                    <td>
                        <input type="text"  name="title" value="<?php echo isset($content['title'])?enhtml($content['title']):''; ?>" class="<?php echo (isset($errTitle)&&($errTitle!=''))?'error_input':''; ?>" />
                        <p class="errName <?php echo (isset($errTitle)&&($errTitle!=''))?'error_put':''; ?>"><?php echo (isset($errTitle)&&($errTitle!=''))?$errTitle:''; ?></p>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <label>Nội dung tin đăng:</label>
                    <td>
                </tr>
                <tr>
                    <td>
                        <textarea  id="elm1" name="content">
                        <?php
                        if(isset($content['content']))
                        {
                            echo enhtml($content['content']);
                        }
                        ?>
                        </textarea>
                    </td>
                </tr>
                
                <tr><td></td></tr>
                
                <tr>
                    <td><label>Chọn ảnh: <span style="font-size: 11px;">(Bạn được đăng 5 ảnh.)</span></label></td>
                </tr>
                <?php 
                if(isset($img[0]) && $img[0]!='')
                {
                    $j=1;
                    foreach($img as $i)
                    {
                ?>
                <tr id="div_choise_img-<?php echo $j; ?>-tr">
                    <td class="borderB">
                    <div style="max-width: 585px; overflow: auto;">
                        <img src="<?php echo $i; ?>" height="60px" />
                        <input style="display: none;" class="div_choise_img" id="div_choise_img-<?php echo $j; ?>" type="text" name="img[]" value="<?php echo $i; ?>" />
                        
                    </div>
                    <div  style="float: right;"><a onclick="deleteImg('<?php echo $j; ?>');">Xóa ảnh</a></div>
                    <div class="clear"></div>
                    </td>
                </tr>
                <?php $j++;}}
                ?>
                <tr class="tr_choise_img"  id="div_choise_img-<?php echo count($img)+1; ?>-tr">
                    <td>
                        <div><input class="div_choise_img" id="div_choise_img-<?php echo count($img)+1; ?>" onchange="abc(this);" type="file" name="img[]" id="file" /></div>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <label>Chọn tỉnh thành:</label>
                    <td>
                </tr>
                
                <tr>
                    <td>
                        <select name="city">
                        <?php
                            foreach($city as $icity)
                            {
                                if($icity['ms']==$content['city'])
                                {
                                    echo '<option selected="" value="'.$icity['ms'].'">'.$icity['city'].'</option>';
                                }
                                else
                                {
                                    echo '<option value="'.$icity['ms'].'">'.$icity['city'].'</option>';
                                }
                            }
                        ?>
                        </select>
                    </td>
                </tr>
                
               
                <tr><td><h3 class="padT10 padB5" style="border-top: 1px solid #EEE;border-bottom: 1px solid #EEE;">Thông tin liên hệ</h3></td></tr>
                
            </table>
            <table  id="tb_lienhe">
                 <tr>
                    <td><label>SĐT liên hệ:</label></td><td style="padding-left:26px !important;"><label>Email liên hệ:</label></td>
                </tr>
                
                <tr>
                    <td><input type="text" name="sdt" value="<?php echo isset($lienhe[0])?$lienhe[0]:''; ?>" /></td><td style="padding-left:26px !important;"><input type="email" name="email" value="<?php echo isset($lienhe[1])?$lienhe[1]:''; ?>" /></td>
                </tr>
                
                
                <tr>
                    <td><label>Yahoo liên hệ:</label></td><td style="padding-left:26px !important;"><label>Skype liên hệ:</label></td>
                </tr>
                
                <tr>
                    <td><input type="text" name="yahoo" value="<?php echo isset($lienhe[2])?$lienhe[2]:''; ?>" /></td><td style="padding-left:26px !important;"><input value="<?php echo isset($lienhe[3])?$lienhe[3]:''; ?>" type="text" name="skype" /></td>
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
                
            </table>
            <input type="submit" name="submit" value="Cập nhật" class="submit_dangtin" />
        </form>
    </div>
</div>

<script type="text/javascript">

if($(".div_choise_img").length>=5)
{
    $("tr.tr_choise_img").hide();
}

$("#cate_news1 ul li").hover(function(){
            $(".cate_news2").hide();
            $("#leftnews2-"+$(this)[0].id).show();
            $("#leftnews2-"+$(this)[0].id+" h3")[0].innerHTML = $(this)[0].innerHTML;
            $("#span_choise_cate")[0].innerHTML = $(this)[0].innerHTML;
            $("input#input_choise_cate").val($(this)[0].innerHTML);
        });
        
        $("#elm1_tbl").css('width','620px');
        
        tinyMCE.init({
		// General options
        selector:"textarea#elm1",
		theme : "advanced",
		skin : "default",
		//plugins : "lists,pagebreak,style,layer,table,advhr,emotions,iespell,preview,contextmenu,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontselect",
		theme_advanced_buttons2 : "bullist,numlist,|,,,,link,unlink,|,forecolor,backcolor,fontsizeselect",

		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
        width:580,
        height:300,
	});
    
    
    
    <?php if(isset($submit)){ ?>
        $("#lst_cate").css('display','none');
        $("#input_data_new, #danhgia").css('display','inline-block');
        $("#span_choise_cate")[0].innerHTML = '<?php echo $cate; ?>';
        $("input#input_choise_cate").val('<?php echo $cate; ?>');
        $("input#input_choise_lvcate").val('<?php echo $catelv; ?>');
        $("#span_choise_lvcate")[0].innerHTML = $("#_"+"<?php echo $catelv; ?>"+" a")[0].innerHTML;
    <?php }?>
    
</script>