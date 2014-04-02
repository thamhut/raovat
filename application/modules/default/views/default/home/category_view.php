<meta name="title" content="<?php echo isset($meta_title)?$meta_title:'chotam.info - Tổng hợp các tin tức rao vặt, mua bán, tìm kiếm hàng ngày.'; ?>" />
<meta name="keywords" content="<?php echo isset($meta_title)?$meta_title:'chotam.info - Tổng hợp các tin tức rao vặt, mua bán, tìm kiếm hàng ngày.'; ?>" />
<meta name="description" content="<?php echo isset($meta_content)?$meta_content:'';?>"/>
<script>
    jQuery(document).ready(function($) {

      $('#banner-fade').bjqs({
        height      : 20,
        width       : 700,
        responsive  : true
      });
      $('#banner-fade').css('overflow','hidden')
      $(".bjqs-controls").remove();
      $(".h-centered").remove();

    });
</script>

<div class="box_container">
    <div class="topbanner_category">
    </div>
    <?php $this->load->view('/menu_view'); ?>
    <div id="cate_level">
    <?php
        echo '<a href="'.base_url('category').'/'.$catelevel[count($catelevel)-1]['id'].'" class="repadL ';
        echo $id==$catelevel[count($catelevel)-1]['id']?'currCate':'';
        echo'">Tất cả</a>';
        foreach($catelevel as $item)
        {
            echo ' |<a href="'.base_url('category').'/'.$item['id_level'].'"  class="';
            echo $id==$item['id_level']?'currCate':'';
            echo '">'.$item['name'].'</a>';
        }
    ?>
    </div>
    <div class="box_data">
        <table width='100%'>
            <tr class="label ">
                <td width=600 class="pad10  alignLeft">
                    <a>Tiêu đề</a>
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
                        <a href="<?php echo site_url('detail/'.$date_city[$itemContent['id']]['title_convert'].'_i'.$itemContent['id']); ?>"><?php echo $itemContent['title']; ?></a>
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
        {if $numCurrItem && $pCount>1}
						{e $this->mycommon->getPage(base_url('category').'/'.$id.'?v=0',$pCount,$cPage,$lstPaging, $numItem)}
				{/if}
    </div>
</div>

<script>
    $(".topbanner_category").css('background','url("/skin/default/img/<?php echo $bannername; ?>_banner.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0)');
</script>