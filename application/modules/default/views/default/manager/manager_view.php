<div >
    <div id="manager_menu">
        <?php $this->load->view('menu_manager_view'); ?>
    </div>
    <div class='menu_input'>
        <b class='fl marT5 marR5'>Chọn tỉnh: </b>
        <div class="div_box_input fl">
            <select class="padT5" id="select_cate">
                <?php 
                 foreach($lstcate as $icate)
                 {
                    if($icate['id']==0)
                    {
                        echo '<option id="cate_'.$icate['id_level'].'" value="'.$icate['id_level'].'">'.$icate['name'].'</option>';
                    }
                 }
                ?>
            </select>
        </div>
    </div>
    <div class="clear"></div>
    <div class="box_data" style="width: 980px; margin:0 auto; background:#FFF;">
        <table width='100%'>
            <tr class="label ">
                <td width=600 class="pad10  alignLeft">
                    <a>Tiêu đề</a>
                </td>
                <td class="pad10  alignLeft" width=72>Số lượt xem</td>
                <td class="pad10  alignLeft" width=90>Ngày đăng</td>
                <td class="pad10  alignLeft">Nơi đăng</td>
                <td class="pad10  alignLeft" width=30>Xóa</td>
            </tr>
            
            <?php 
            $i=0;
                foreach($lstContent as $itemContent)
                {
                    $i++;
            ?>
                <tr class="item_data <?php echo $i%2==0?'odd':''; ?>">
                    <td class="pad10  alignLeft">
                        <a target="_blank" href="<?php echo site_url('detail/'.$date_city[$itemContent['id']]['title_convert'].'_i'.$itemContent['id']); ?>"><?php echo enhtml($itemContent['title']); ?></a>
                        <div style="background: none repeat scroll 0 0 #FFFFC0;width: 400px;border: 2px solid #B0B2B0; display:none;">abc abc abc abc abc</div>
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
                    <td class="pad10 alignLeft"><?php echo $date_city[$itemContent['id']]['city']; ?></td>
                    <td class="pad10 alignCenter" ><a href="<?php echo base_url('manager/deleteContent').'?v=0&numItem='.$numItem.'&cpage='.$cPage.'&id='.$itemContent['id']; ?>">Xóa</a></td>
                </tr>
            <?php }?>
        </table>
        {if $numCurrItem && $pCount>1}
						{e $this->mycommon->getPage(base_url('manager').'?v=0',$pCount,$cPage,$lstPaging, $numItem)}
				{/if}
    </div>
</div>

<script>
    $("#select_cate").change(function(){
    });
</script>