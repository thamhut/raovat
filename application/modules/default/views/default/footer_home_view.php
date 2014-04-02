<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	
</div>

<div class="box_footer">
    <div class='box_common'>
        Chợ rao vặt tổng hợp - Copyright © 2014
    </div>
</div>
</body>
</html>

<script>
    $(function(){
        $(".leftmenu1 ul li").hover(function(){
            $(this).find('div').show();
            $("#leftmenu2-"+$(this)[0].id).css('top',$(this).offset().top-$("#leftmenu2-"+$(this)[0].id).height()/2);
            $("#leftmenu2-"+$(this)[0].id).show();
            $(this).css('border-left','1px solid #938693');
            $(this).css('border-top','1px solid #938693');
            $(this).css('border-bottom','1px solid #938693');
            $(this).css('border-right','1px solid #FFFFFF');
            $(this).css('background','#FFF');
            $(this).css('color','#222000');
        },function(){
            $(this).find('div').hide();
            $("#leftmenu2-"+$(this)[0].id).hide();
            $(this).css('border-left','1px solid #6ACD65');
            $(this).css('border-top','1px solid #FFFFFF');
            $(this).css('border-bottom','1px solid #EEEEEE');
            $(this).css('border-right','1px solid #6ACD65');
            $(this).css('background','url("/skin/default/img/icon_arrow_r.gif") no-repeat');
            $(this).css('color','#44404E');  
        });
        
        $(".leftmenu2").hover(function(){
                $(this).show();
                var menu = $(this)[0].id.split('-');
                $("#"+menu[1]).find('div').show();
                $("#"+menu[1]).css('border-left','1px solid #938693');
                $("#"+menu[1]).css('border-top','1px solid #938693');
                $("#"+menu[1]).css('border-bottom','1px solid #938693');
                $("#"+menu[1]).css('border-right','1px solid #FFFFFF');
                $("#"+menu[1]).css('background','#FFF');
            },function(){
                $(this).hide();
                var menu = $(this)[0].id.split('-');
                $("#"+menu[1]).find('div').hide();
                $("#"+menu[1]).css('border-left','1px solid #6ACD65');
                $("#"+menu[1]).css('border-top','1px solid #FFFFFF');
                $("#"+menu[1]).css('border-bottom','1px solid #EEEEEE');
                $("#"+menu[1]).css('border-right','1px solid #6ACD65');
                $("#"+menu[1]).css('background','url("/skin/default/img/icon_arrow_r.gif") no-repeat');
                $("#"+menu[1]).css('color','#44404E');
        });
        
        $("#a_login").click(function(e)
        {
            e.stopPropagation();
            $("#frmlogin").toggle();
        });
        
        $(".choise_city").click(function(){
            $("#show_city").toggle();
        });
        $("#danhmucchinh").click(function()
        {
            $(".arrow_down_menu").toggle();
            $("#box_danhmucchinh").toggle();
        });
        $("body").click(function() { 
    	 	$('#show_city').hide();
            $("#box_danhmucchinh").hide();
            $(".arrow_down_menu").hide();
            $("#frmlogin").hide();
    	});
    
    	$('.choise_city').click(function(e){ 
    	     e.stopPropagation();
    	});
        
        $("#danhmucchinh").click(function(e){ 
    	     e.stopPropagation();
    	});
        $(".arrow_down_menu").click(function(e){ 
    	     e.stopPropagation();
    	});
        $("#frmlogin").click(function(e){
            e.stopPropagation();
        })
        
    });
    
    $("div.topbanner_category").css('background','url("<?php echo base_url(); ?>skin/default/img/<?php echo $bannername; ?>_banner.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0)');
</script>