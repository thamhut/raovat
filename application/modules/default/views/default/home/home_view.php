<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script>
    jQuery(document).ready(function($) {

      $('#banner-fade').bjqs({
        height      : 245,
        width       : 660,
        animduration    : 2000,      // length of transition
        animspeed       : 5500,
        responsive  : true
      });
      $('#banner-fade').css('overflow','hidden')
      $(".bjqs-controls").remove();
      $(".h-centered").remove();

    });
</script>
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
        <ul>
        <?php
        foreach($news as $inew)
            echo '<li><a class="padL8" href="'.site_url('detail/'.$title[$inew['id']]['title_convert'].'_i'.$inew['id']).'">'.enhtml($inew['title']).'</a></li>';
        ?>
        </ul>
        
    </div>
    <div class="clear"></div>
    <?php $this->load->view('/menu_view'); ?>
    <div class="box_data remarT" >
        <div class="layout_danhmuc">
            <ul>
                <li class="title_cate">
                    <a href="{e base_url('category/1')}">Việc làm</a>
                </li>
                <?php
                foreach($cate as $item)
                {
                    if($item['id']==1)
                    {
                        echo '<li><a href="'.base_url('category').'/'.$item['id_level'].'">'.$item['name'].'</a></li>';
                    }
                }
                ?>
            </ul>
            <ul>
                <li class="title_cate">
                    <a href="{e base_url('category/13')}">Bất động sản</a>
                </li>
                <?php
                foreach($cate as $item)
                {
                    if($item['id']==13)
                    {
                        echo '<li><a href="'.base_url('category').'/'.$item['id_level'].'">'.$item['name'].'</a></li>';
                    }
                }
                ?>
            </ul>
            
            <ul>
                <li class="title_cate">
                    <a href="{e base_url('category/18')}">Điện thoại</a>
                </li>
                <?php
                foreach($cate as $item)
                {
                    if($item['id']==18)
                    {
                        echo '<li><a href="'.base_url('category').'/'.$item['id_level'].'">'.$item['name'].'</a></li>';
                    }
                }
                ?>
            </ul>
        </div>
        <div class="layout_danhmuc">
            <ul>
                <li class="title_cate">
                    <a href="{e base_url('category/26')}">Mua bán</a>
                </li>
                <?php
                foreach($cate as $item)
                {
                    if($item['id']==26)
                    {
                        echo '<li><a href="'.base_url('category').'/'.$item['id_level'].'">'.$item['name'].'</a></li>';
                    }
                }
                ?>
            </ul>
            
            <ul>
                <li class="title_cate">
                    <a href="{e base_url('category/37')}">Điện tử gia dụng</a>
                </li>
                <?php
                foreach($cate as $item)
                {
                    if($item['id']==37)
                    {
                        echo '<li><a href="'.base_url('category').'/'.$item['id_level'].'">'.$item['name'].'</a></li>';
                    }
                }
                ?>
            </ul>
            <ul>
                <li class="title_cate">
                    <a href="{e base_url('category/45')}">Máy tính</a>
                </li>
                <?php
                foreach($cate as $item)
                {
                    if($item['id']==45)
                    {
                        echo '<li><a href="'.base_url('category').'/'.$item['id_level'].'">'.$item['name'].'</a></li>';
                    }
                }
                ?>
            </ul>
        </div>
        <div class="layout_danhmuc">
            <ul>
                <li class="title_cate">
                    <a href="{e base_url('category/52')}">Phương tiện đi lại</a>
                </li>
                <?php
                foreach($cate as $item)
                {
                    if($item['id']==52)
                    {
                        echo '<li><a href="'.base_url('category').'/'.$item['id_level'].'">'.$item['name'].'</a></li>';
                    }
                }
                ?>
            </ul>
            <ul>
                <li class="title_cate">
                    <a href="{e base_url('category/59')}">Thời trang - mỹ phẩm</a>
                </li>
                <?php
                foreach($cate as $item)
                {
                    if($item['id']==59)
                    {
                        echo '<li><a href="'.base_url('category').'/'.$item['id_level'].'">'.$item['name'].'</a></li>';
                    }
                }
                ?>
            </ul>
            <ul>
                <li class="title_cate">
                    <a href="{e base_url('category/65')}">Mẹ và bé</a>
                </li>
                <?php
                foreach($cate as $item)
                {
                    if($item['id']==65)
                    {
                        echo '<li><a href="'.base_url('category').'/'.$item['id_level'].'">'.$item['name'].'</a></li>';
                    }
                }
                ?>
            </ul>
        </div>
        <div class="layout_danhmuc" style="border-right: 1px solid #FFF;">
            <ul>
                <li class="title_cate">
                    <a href="{e base_url('category/72')}">Sim thẻ</a>
                </li>
                <?php
                foreach($cate as $item)
                {
                    if($item['id']==72)
                    {
                        echo '<li><a href="'.base_url('category').'/'.$item['id_level'].'">'.$item['name'].'</a></li>';
                    }
                }
                ?>
            </ul>
            
            <ul>
                <li class="title_cate">
                    <a href="{e base_url('category/80')}">Dịch vụ</a>
                </li>
                <?php
                foreach($cate as $item)
                {
                    if($item['id']==80)
                    {
                        echo '<li><a href="'.base_url('category').'/'.$item['id_level'].'">'.$item['name'].'</a></li>';
                    }
                }
                ?>
            </ul>
        </div>
        <div class="clear"></div>
        
        <!--<table width='100%'>
            <tr class="label ">
                <td width=570 class="pad5  alignLeft">
                    <a>Danh mục một</a>
                </td>
                <td class="pad5  alignLeft" width=90>Số lượt xem</td>
                <td class="pad5  alignLeft" width=90>Ngày đăng</td>
                <td class="pad5  alignLeft  ">Nơi đăng</td>
            </tr>
            
            <tr class="item_data odd">
                <td class="pad5  alignLeft">
                    tin rao vawtj soos 1
                </td>
                <td class="pad5  alignLeft" >100</td>
                <td class="pad5  alignLeft  " >12/1/2014</td>
                <td class="pad5  alignLeft  ">Ha noi</td>
            </tr>
            
            <tr class="item_data event">
                <td class="pad5  alignLeft">
                    tin rao vawtj soos 1tin rao vawtj soos 1tin rao vawtj soos 1
                </td>
                <td class="pad5  alignLeft" >100</td>
                <td class="pad5  alignLeft  " >12/1/2014</td>
                <td class="pad5  alignLeft  ">Ha noi</td>
            </tr>
            <tr class="item_data odd">
                <td class="pad5  alignLeft">
                    tin rao vawtj soos 1
                </td>
                <td class="pad5  alignLeft" >100</td>
                <td class="pad5  alignLeft  " >12/1/2014</td>
                <td class="pad5  alignLeft  ">Ha noi</td>
            </tr>
            
            <tr class="item_data event">
                <td class="pad5  alignLeft">
                    tin rao vawtj soos 1
                </td>
                <td class="pad5  alignLeft" >100</td>
                <td class="pad5  alignLeft  " >12/1/2014</td>
                <td class="pad5  alignLeft  ">Ha noi</td>
            </tr>
        </table>-->
    </div>
</div>
<script>

</script>