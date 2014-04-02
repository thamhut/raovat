<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="topmenu">
    <ul class="ul_topmenu">
        <li class="pad8" id="danhmucchinh"><span>Danh mục chính</span></li>
        <?php 
        $lstCate = $this->home_model->getall_category();
        if(isset($name1)&&$name1!='')
        {
            echo '<li class="pad8" id=""><span>'.$name1.'</span></li>';
            echo $name2!=''?'<li class="pad8" id=""><span>'.$name2.'</span></li>':'';
        }
        ?>
    </ul>
    <div class="arrow_down_menu marleft10"></div> 
</div>

<div id="box_danhmucchinh" class="leftmenu1 martop8">
    <ul>
        <?php
        foreach($lstCate as $icate)
        {
            if($icate['id']==0){
        ?>
            <li id="menuli_<?php echo $icate['id_level']; ?>"><a href="<?php echo base_url('category/'.$icate['id_level'])?>"><?php echo $icate['name']; ?></a><div class="arrow_left_menu"></div></li>
        <?php }}?>
        <!--<li id="menuli_1"><span>Danh mục phụ 1</span><div class="arrow_left_menu"></div></li>
        <li id="menuli_2"><span>Danh mục phụ 1</span><div class="arrow_left_menu"></div></li>
        <li id="menuli_3"><span>Danh mục phụ 1</span><div class="arrow_left_menu"></div></li>-->
    </ul>
</div>

<?php 
foreach($lstCate as $icate)
{
    if($icate['id']==0){
?>
    <div id="leftmenu2-menuli_<?php echo $icate['id_level']; ?>" class="leftmenu2">
        <ul>
        <?php
        foreach($lstCate as $icate2)
        {
            if($icate2['id']==$icate['id_level'])
            {
                echo '<li><a href="'.base_url('category/'.$icate2['id_level']).'">'.$icate2['name'].'</a></li>';
            }
        }
        ?>
        </ul>
    </div>
<?php
}}
?>
