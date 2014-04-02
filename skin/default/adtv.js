adtv = {
	url:{
		
	},	
	init:function(){
		try
		{			
			this.initEvent();		
		}
		catch (e)
		{
			console.log(e);
		}
	},
	initEvent:function(){
		var This = this;		
		This.update = function(){			
			$(".number-page").click(function(){
				var This_page = this;
				ajaxData = {};
				ajaxData['page'] = $(this).attr('id');
				ajaxData['cat_id'] = $(this).attr('cat_id');
				$.ajax({
					url: "/adtv/ajaxtv",
					type: 'post',				
					data: ajaxData,
					success:function(response){
						$("#content_"+ajaxData['cat_id']).html(response);						
						$(".a-select").removeClass('a-select');
						$(This_page).addClass('a-select');
					}
				});
			});
			
		}
		This.update();			
	},		
} 

$(document).ready(function(){		
	adtv.init();	
});