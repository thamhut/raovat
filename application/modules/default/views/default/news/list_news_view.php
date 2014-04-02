<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="box_container">
    <div class="topbanner_category">
    </div>
    <div id="news_nav_filter" >
        <label><b>Chọn tỉnh: </b></label>&nbsp;<select id="news_select_city">
        <?php
            foreach($city as $icity)
            {
                if($icity['ms']==$selectcity)
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
        
        <label><b>Chuyên mục: </b></label>&nbsp;<select id="news_select_cate">
        <?php
        foreach($this->home_model->getall_category() as $icate)
        {
            if($icate['id']==0){
        ?>
            <option <?php echo ($icate['id_level']==$cate)?'selected':'' ?> value="<?php echo $icate['id_level'];?>"><?php echo $icate['name']; ?></option>
        <?php }
            else
            {
                if(($icate['id_level']==$cate))
                {
                    echo '<option selected value="'.$icate['id_level'].'">---'. $icate['name'].'</option>';
                }
                else
                {
                    echo '<option value="'.$icate['id_level'].'">---'. $icate['name'].'</option>';
                }
            }
        }?>
        </select>
        
        <label><b>Từ khóa </b></label>&nbsp;<input class="input_keyword" type="text"  />
         <input class="input_search" onclick="find_news();" type="button" value="Tìm kiếm" />
    </div>
    <div class="">
        <table width='100%'>
            <tr class="label ">
                <td width=600 class="pad10  alignLeft">
                    <a>Danh sách tin đăng</a>
                    <?php if($this->input->get('msg')) echo '<span class="error_put">'.$this->input->get('msg').'</span>';?>
                </td>
                <td class="pad10  alignLeft" width=80>Số lượt xem</td>
                <td class="pad10  alignLeft" width=90>Ngày đăng</td>
                <td class="pad10  alignLeft  ">Nơi đăng</td>
                <td class="pad10  alignCenter  ">Xóa</td>
            </tr>
            
            <?php 
            $i=0;
                foreach($lstItem as $itemContent)
                {
                    $i++;
            ?>
                <tr class="item_data <?php echo $i%2==0?'odd':''; ?>">
                    <td class="pad10 wordbreak alignLeft">
                        <a href="<?php echo site_url('detail/'.$date_city[$itemContent['id']]['title_convert'].'_i'.$itemContent['id']); ?>"><?php echo enhtml($itemContent['title']); ?></a>
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
                            echo 'Vừa xong.';
                        }
                     ?></td>
                    <td class="pad10  alignLeft  "><?php echo $date_city[$itemContent['id']]['city']; ?></td>
                    <td class="pad10  alignCenter  "><a onclick="return deleted_news();" href="<?php echo base_url('news/deleteContent').'?id='.$itemContent['id'].'&cpage='.$cpage.'&city='.$selectcity.'&keyword='.$keyword.'&cate='.$cate; ?>" >Xóa</a></td>
                </tr>
            <?php }?>
        </table>
        {if $numCurrItem && $pCount>1}
						{e $this->mycommon->getPage(base_url('news/mynews').'?v=0',$pCount,$cpage,$lstPaging, $numItem)}
				{/if}
    </div>
</div>

<script type="text/javascript">
    $("#news_select_city").change(function(){
       window.location = '<?php echo base_url('news/mynews').'?cate='.$cate.'&keyword='.$keyword.'&cpage='.$cpage; ?>&city='+$("#news_select_city").val();
    });
    
    $("#news_select_cate").change(function(){
       window.location = '<?php echo base_url('news/mynews').'?city='.$selectcity.'&keyword='.$keyword.'&cpage='.$cpage; ?>&cate='+$("#news_select_cate").val();
    });
    
</script>