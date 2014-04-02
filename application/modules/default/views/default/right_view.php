<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!-- right bar -->
<td width="280">
	<div class="promoModuleCNET"> 
		<p>Hotline: 0974.68.0000</p> 
		<div style="padding:10px;text-align:center;"><img width="260" alt="{e $common_lang['contactus']} {e $setting['seo_title']}" title="{e $common_lang['contactus']} {e $setting['seo_title']}" src="/skin/default/images/contact_us.gif"></div>
	</div>
	<div class="rightLstImg">
		{loop $lstItem $k}
			<div class="img"><a href="{e $k['href']}" title="{e $k['title']}"><img src="{e $this->mycommon->cut_thumb($k['thumb'])}" alt="{e $k['title']}" title="{e $k['title']}"></a></div>
			<div class="bbtom"></div>
		{/loop}
	</div>
</td>
<!-- end right bar -->
	

