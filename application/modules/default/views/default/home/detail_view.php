<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<meta name="title" content="<?php echo isset($meta_title)?$meta_title:'chotam.info - Tổng hợp các tin tức rao vặt, mua bán, tìm kiếm hàng ngày.'; ?>" />
<meta name="keywords" content="<?php echo isset($meta_title)?$meta_title:'chotam.info - Tổng hợp các tin tức rao vặt, mua bán, tìm kiếm hàng ngày.'; ?>" />
<meta name="description" content='<?php echo isset($meta_content)?$meta_content:'';?>'/>
<div class="box_container">
    
    <?php $this->load->view('/menu_view'); ?>
    <div class="box_data box_detail">
        <div id="title" class="wordbreak"><h2><?php echo enhtml($content['title']); ?></h2></div>
        <div style="float:right; border-width: 0 !important; border-style: none !important;">
            <div class="fb-share-button" data-href="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REDIRECT_URL']; ?>" data-type="button_count"></div>
        </div>
        <div id="data_news" class="line_bottom">
            <table width=75%>
                <tr>
                    <td width=90>Người đăng:</td>
                    <td width=350><?php if($content['id_user']==1) echo 'Admin'; ?></td>
                    <td width=90>Ngày đăng:</td>
                    <td width=200><?php
                        if($date_detail['d']!=0)
                        {
                            echo $date_detail['d'].' ngày trước.';
                        }
                        else if($date_detail['h']!=0)
                        {
                            echo $date_detail['h'].' giờ trước.';
                        }
                        else if($date_detail['i']!=0)
                        {
                            echo $date_detail['i'].' phút trước';
                        }
                        else
                        {
                            echo date('d-m-Y', strtotime($content['date']));
                        }
                     ?></td>
                </tr>
                <tr>
                    <td>Địa điểm:</td>
                    <td><?php echo $city; ?></td>
                    <td>Email:</td>
                    <td><?php echo $lienlac[1]; ?></td>
                </tr>
                <tr>
                    <td>SĐT:</td>
                    <td><?php echo $lienlac[0]; ?></td>
                    <td>YIM/Skype:</td>
                    <td><?php echo isset($lienlac[2])?$lienlac[2]:''; ?> /  <?php echo isset($lienlac[3])?$lienlac[3]:''; ?></td>
                </tr>
            </table>
            
            <?php
            $user = getCacheUser('user');
             if($user && $user['id'] == $content['id_user']){ ?>
            <div>
                <ul>
                    <li class="borderB">
                        <a href="<?php echo base_url('news/newsinfo?id=').$content['id']; ?>">Sửa tin</a>
                    </li>
                    <li><a href="<?php echo base_url('news/deleteContent?id=').$content['id']; ?>" onclick="return deleted_news();">Xóa</a></li>
                </ul>
            </div>
            <?php }?>
        </div>
        <?php if($content['img'][0]!=''){ ?>
        <div id="image">
            <div id='showimage'><img src="<?php echo $content['img'][0];  ?>" <?php list($w_orig, $h_orig) = getimagesize($content['img'][0]); if($w_orig>$h_orig) echo 'width="300px"'; else echo 'height="300px"'; ?> /></div>
            <div style=" position:absolute; bottom: 0; left:5px" class="borderT padT10">
                <ul>
                    <li id="1" style="border: 1px solid ;"><img src="<?php echo isset($content['img'][0])?($content['img'][0]!=''?$content['img'][0]:base_url().'skin/default/img/noimage.png'):base_url().'skin/default/img/noimage.png';  ?>" width="40px" /></li>
                    <li id="2"><img src="<?php echo isset($content['img'][1])?($content['img'][1]!=''?$content['img'][1]:base_url().'skin/default/img/noimage.png'):base_url().'skin/default/img/noimage.png';  ?>" width="40px" height="40px" /></li>
                    <li id="3"><img src="<?php echo isset($content['img'][2])?($content['img'][2]!=''?$content['img'][2]:base_url().'skin/default/img/noimage.png'):base_url().'skin/default/img/noimage.png';  ?>" width="40px" height="40px" /></li>
                    <li id="4"><img src="<?php echo isset($content['img'][3])?($content['img'][3]!=''?$content['img'][3]:base_url().'skin/default/img/noimage.png'):base_url().'skin/default/img/noimage.png';  ?>" width="40px" height="40px" /></li>
                    <li id="5"><img src="<?php echo isset($content['img'][4])?($content['img'][4]!=''?$content['img'][4]:base_url().'skin/default/img/noimage.png'):base_url().'skin/default/img/noimage.png';  ?>" width="40px" height="40px" /></li>
                </ul>
            </div>
        </div>
        <?php }?>
        <div id="des" class="padT10">
            <h3>Nội dung đăng:</h3>
            <div class="padT5">
                <?php echo ($content['content']); ?>
            </div>
            <?php if($content['id_user']!=2){ ?>
            <div>
                <div data-width="750" data-numposts="10" class="fb-comments" data-href="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REDIRECT_URL']; ?>" data-numposts="5" data-colorscheme="light"></div>
            </div>
            <?php } ?>
        </div>
    </div>
    
    <div class="clear"></div>
    <div id="fb-root" style="width:700px !important;"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <div class="">
        <table width='100%'>
            <tr class="label ">
                <td width=600 class="pad10  alignLeft">
                    <a>Tin rao cùng danh mục</a>
                </td>
                <td class="pad10  alignLeft" width=40>Xem</td>
                <td class="pad10  alignLeft" width=90>Ngày đăng</td>
                <td class="pad10  alignLeft  ">Nơi đăng</td>
            </tr>
            
            <?php 
            $i=0;
                foreach($lstContent as $itemContent)
                {
                    $i++;
            ?>
                <tr class="item_data <?php echo $i%2==0?'odd':''; ?>">
                    <td class="pad10 wordbreak alignLeft">
                        <a href="<?php echo site_url('detail/'.$date_city[$itemContent['id']]['title_convert'].'_i'.$itemContent['id']); ?>"><?php echo enhtml($itemContent['title']); ?></a>
                        <a href="<?php echo site_url('detail/'.$date_city[$itemContent['id']]['title_convert'].'_i'.$itemContent['id']); ?>">
                        <div class="lstimg">
                        <?php for($j=0;$j<3; ++$j){ 
                            if(isset($date_city[$itemContent['id']]['img'][$j])&&$date_city[$itemContent['id']]['img'][$j]!='')
                            {
                                echo '<div><img class="marT10" width="90px" height="90px" src="'.$date_city[$itemContent['id']]['img'][$j].'"></div>';
                            }
                        } ?>
                        </div>
                        </a>
                    </td>
                    <td class="pad10  alignLeft" ><?php echo $itemContent['view']; ?></td>
                    <td class="pad10  alignLeft  " ><?php
                        if($date_city[$itemContent['id']]['date']['d']!=0)
                        {
                            echo $date_city[$itemContent['id']]['date']['d'].' ngày trước.';
                        }
                        else if($date_city[$itemContent['id']]['date']['h']!=0)
                        {
                            echo $date_city[$itemContent['id']]['date']['h'].' giờ trước.';
                        }
                        else if($date_city[$itemContent['id']]['date']['i']!=0)
                        {
                            echo $date_city[$itemContent['id']]['date']['i'].' phút trước';
                        }
                        else
                        {
                            echo date('d-m-Y', strtotime($itemContent['date']));
                        }
                     ?></td>
                    <td class="pad10  alignLeft  "><?php echo $date_city[$itemContent['id']]['city']; ?></td>
                </tr>
            <?php }?>
        </table>
    </div>
</div>

<script>
    //$(".choise_city").remove();
    $("#box_danhmucchinh").show();
    $(".arrow_down_menu").show();
    $("#image div ul li").hover(function(e)
    {
        $("#showimage").html(this.innerHTML);
        $("#showimage img").removeAttr('width');
        $("#showimage img").removeAttr('height');
        $("#image div ul li").css('border','1px solid #EEE');
        $(this).css('border','1px solid');
        if(this.id==1)
        {
            <?php
            if(isset($content['img'][0])&&$content['img'][0]!='' && getimagesize($content['img'][0])==true){
                list($w_orig, $h_orig) = getimagesize($content['img'][0]); if($w_orig>$h_orig) echo '$("#showimage img").css("width","300px");'; else echo '$("#showimage img").css("height","300px");'; 
            }
            else echo '$("#showimage img").css("width","300px");'; 
            ?>
        }
        if(this.id==2)
        {
            <?php
            if(isset($content['img'][1])&&$content['img'][1]!='' && getimagesize($content['img'][1])==true){
            list($w_orig, $h_orig) = getimagesize($content['img'][1]); if($w_orig>$h_orig) echo '$("#showimage img").css("width","300px");'; else echo '$("#showimage img").css("height","300px");'; 
            }
            else echo '$("#showimage img").css("width","300px");'; 
            ?>
        }
        if(this.id==3)
        {
            <?php
            if(isset($content['img'][2])&&$content['img'][2]!='' && getimagesize($content['img'][2])==true){
            list($w_orig, $h_orig) = getimagesize($content['img'][2]); if($w_orig>$h_orig) echo '$("#showimage img").css("width","300px");'; else echo '$("#showimage img").css("height","300px");'; 
            }
            else echo '$("#showimage img").css("width","300px");'; 
            ?>
        }
        if(this.id==4)
        {
            <?php
            if(isset($content['img'][3])&&$content['img'][3]!='' && getimagesize($content['img'][3])==true){
            list($w_orig, $h_orig) = getimagesize($content['img'][3]); if($w_orig>$h_orig) echo '$("#showimage img").css("width","300px");'; else echo '$("#showimage img").css("height","300px");'; 
            }
            else echo '$("#showimage img").css("width","300px");'; 
            ?>
        }
        if(this.id==5)
        {
            <?php
            if(isset($content['img'][4])&&$content['img'][4]!='' && getimagesize($content['img'][4])==true){
            list($w_orig, $h_orig) = getimagesize($content['img'][4]); if($w_orig>$h_orig) echo '$("#showimage img").css("width","300px");'; else echo '$("#showimage img").css("height","300px");'; 
            }
            else echo '$("#showimage img").css("width","300px");'; 
            ?>
        }
    });
    
</script>