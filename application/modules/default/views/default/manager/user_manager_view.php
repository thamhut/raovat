<div >
    <div id="manager_menu">
        <?php $this->load->view('menu_manager_view'); ?>
    </div>
    <div class="clear"></div>
    <div class="box_data" style="width: 980px; margin:0 auto; background:#FFF;">
        <table width='100%'>
            <tr class="label ">
                <td width=200 class="pad10  alignLeft">
                    Tên đăng nhập
                </td>
                <td class="pad10  alignLeft">Email</td>
                <td class="pad10  alignLeft" width=180>Ngày gia nhập</td>
                <td class="pad10  alignLeft" width=80>Quản lý</td>
            </tr>
            <?php $i=0; foreach($lstUser as $iuser){ $i++; ?>
            <tr class=" <?php echo $i%2==0?'odd':''; ?>">
                <td width=600 class="pad10  alignLeft">
                    <?php echo isset($iuser['username'])?$iuser['username']:''; ?>
                </td>
                <td class="pad10  alignLeft">
                    <?php echo isset($iuser['email'])?$iuser['email']:''; ?>
                </td>
                <td class="pad10  alignLeft">
                    <?php echo isset($iuser['date'])?$iuser['date']:''; ?>
                </td>
                <td class="pad10  alignLeft" width=30>
                    <a href="<?php echo base_url('manager/deleteuser?id=').$iuser['id']; ?>">Xóa</a> | 
                    <a href="<?php echo base_url('manager/loginbyuser?id=').$iuser['id']; ?>">Login</a>
                </td>
            </tr>
            <?php } ?>
            
        </table>
        {if $numCurrItem && $pCount>1}
            {e $this->mycommon->getPage(base_url('manager/usermanager').'?v=0',$pCount,$cPage,$lstPaging, $numItem)}
		{/if}
    </div>
</div>

<script>
    $("#select_cate").change(function(){
    });
</script>