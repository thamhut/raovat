function Dalbums(id,mid,w) {
	var c = '<iframe name="UploadAlbum" style="display: none" src=""></iframe>';
	c += '<form method="post" target="UploadAlbum" enctype="multipart/form-data" action="'+base_url+'admin/upload?mid='+mid+'" onsubmit="return isImg(\'file_upload\');">';
	c += '<input type="hidden" name="id" value="'+id+'"/><table cellpadding="3"><tr><td>';
	c += '<input id="file_upload" type="file" size="20" name="file_upload"/></td></tr><tr style="display:"><td>';
	c += '<input type="submit"  value="Upload" />&nbsp;&nbsp;<input type="button"  value="Bỏ qua" onclick="cDialog();"/></td></tr></table></form>';
	c = '<div id="Dmid" onclick="cDialog();"></div><div id="Dtop"><div class="dbody"><div class="dhead" ><span onclick="cDialog();">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;Upload ảnh</div><div class="dbox">'+c+'</div></div></div>';
	$('body').append(c);
	$('#Dmid').css('height',$(document).height());
	$('#Dtop').css('width',w).css('top',($(window).height()-150)/2).css('left',($(window).width()- w)/2);
}
function Dfile(id,mid,w) {
	var c = '<iframe name="UploadAlbum" style="display: none" src=""></iframe>';
	c += '<form method="post" target="UploadAlbum" enctype="multipart/form-data" action="'+base_url+'admin/upload?mid='+mid+'">';
	c += '<input type="hidden" name="id" value="'+id+'"/><table cellpadding="3"><tr><td>';
	c += '<input id="file_upload" type="file" size="20" name="file_upload"/></td></tr><tr style="display:"><td>';
	c += '<input type="submit"  value="Upload" />&nbsp;&nbsp;<input type="button"  value="Bỏ qua" onclick="cDialog();"/></td></tr></table></form>';
	c = '<div id="Dmid" onclick="cDialog();"></div><div id="Dtop"><div class="dbody"><div class="dhead" ><span onclick="cDialog();">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;Upload ảnh</div><div class="dbox">'+c+'</div></div></div>';
	$('body').append(c);
	$('#Dmid').css('height',$(document).height());
	$('#Dtop').css('width',w).css('top',($(window).height()-150)/2).css('left',($(window).width()- w)/2);
}
function cDialog() {
	$('#Dmid').remove();
	$('#Dtop').remove();
}
function getAlbum(v,id) {
	$('#showthumb'+id).attr('src',v);
	$('#thumb'+id).val(v);
}
function getFields(v,n,id,w,h) {
	$('#_pre_'+id).attr('onclick',"_preview('"+n+"',"+w+","+h+");").css('display','');
	$('#'+id).val(v);
}
function getFieldsFile(v,id) {
	$('#_pre_'+id).attr('onclick','window.open("'+v+'", "_blank");').css('display','');
	$('#'+id).val(v);
}
function getiFrame(v,vi) {
	$('#iFrame').append('<div style="text-align:left;"><span><img style="vertical-align: text-top;margin-top:-3px;border:1px solid #ccc" src="'+v+'" width="20" height="20"/></span>&nbsp;<span><input style="width:125px;" type="text" value="'+vi+'"/></span></div>');
}
function delAlbum(id, s) {
	$('#thumb'+id).val('');
	$('#showthumb'+id).attr('src',s);
}
function isImg(ID) {
	var v = $('#'+ID).val();
	if(v == '') {
		alert('Hãy lựa chọn môt file');
		return false;
	}	
	var file_ext = ext(v);
	file_ext = file_ext.toLowerCase();
	var allow = "jpg|gif|png|jpeg";
	if(allow.indexOf(file_ext) == -1){
		alert('Đ�?nh dạng cho phép: '+allow+'');
		return false;
	}
	return true;
}
function ext(v) {
	return v.substring(v.lastIndexOf('.')+1, v.length);
}
function _preview(src,w,h) {
	if(src) {
		var c = '<img src="'+src+'" width="'+(w)+'px"/>';
		c = '<div id="Dmid" onclick="cDialog();"></div><div id="Dtop"><div class="dbody"><div class="dhead" ><span onclick="cDialog();">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;Preview image</div><div class="dbox">'+c+'</div></div></div>';
		$('body').append(c);
		$('#Dmid').css('height',$(document).height());
		$('#Dtop').css('width',(w+20)).css('top',($(window).height()-150)/2).css('left',($(window).width()- w)/2);
		return true;
	}
	return false;
}
function _preCopy(src) {
	if(src) {
		var c = '<input readonly="readonly" value="'+src+'" type="text" style="width:300px;"/>';
		c = '<div id="Dmid" onclick="cDialog();"></div><div id="Dtop"><div class="dbody"><div class="dhead" ><span onclick="cDialog();">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;Copy link image</div><div class="dbox">'+c+'</div></div></div>';
		$('body').append(c);
		$('#Dmid').css('height',$(document).height());
		$('#Dtop').css('width',(320)).css('top',($(window).height()-150)/2).css('left',($(window).width()- 320)/2);
		return true;
	}
	return false;
}
function _islink(a) {
	
	if(a==1){
		$('#islink-1').css('display','none');
		$('#islink_1').css('display','none');
		$('#islink-0').css('display','');
	}else{
		$('#islink-0').css('display','none');
		$('#islink-1').css('display','');
		$('#islink_1').css('display','');
	}
}
function __islink() {
	if($('#islink').attr('checked')){
		$('#islink-1').css('display','none');
		$('#islink_1').css('display','none');
		$('#islink-0').css('display','');
	}else{
		$('#islink-0').css('display','none');
		$('#islink-1').css('display','');
		$('#islink_1').css('display','');
	}
}
function _isStyle(a){
	if(a==1){
		$('#image').css('display','');
		$('#flashFile').css('display','none');
		$('#flashLink').css('display','none');
		$('#text').css('display','none');
		$('#_href').css('display','');
	}else if(a==2){
		$('#image').css('display','none');
		$('#flashFile').css('display','');
		$('#flashLink').css('display','none');
		$('#text').css('display','none');
		$('#_href').css('display','none');
	}else if(a==3){
		$('#image').css('display','none');
		$('#flashFile').css('display','none');
		$('#flashLink').css('display','');
		$('#text').css('display','none');
		$('#_href').css('display','none');
	}else if(a==4){
		$('#image').css('display','none');
		$('#flashFile').css('display','none');
		$('#flashLink').css('display','none');
		$('#text').css('display','');
		$('#_href').css('display','none');
	}
}
function _addtags() {
		var addtag = $('#addtag').val();
		var tag = $('#tag').val();
		if(addtag!=''){
			$.ajax({
				url: base_url + 'admin/tags/add?title='+addtag,
				success: function(data) {
					var a = '<span id="_tag" style="cursor: pointer;" onclick="$(this).remove();_removetag(\''+addtag+'\');" title="'+addtag+'"><span class="state icon-deletess"> </span> '+addtag+'</span> ';
						$('#lsttags').css('display','').append(a);
						$('#tag').val(tag+addtag+',');
						$('#addtag').val('');
					if(data==2){
						$('span[rel="'+addtag+'"]').remove();
					}
				}
			});
		}else{
			alert('Ban hay nhap tu khoa can them!');
		}
	}
function _addtagdata(addtag) {
		var tag = $('#tag').val();
		var a = '<span id="_tag" style="cursor: pointer;" onclick="$(this).remove();_removetag(\''+addtag+'\');" title="'+addtag+'"><span class="state icon-deletess"> </span> '+addtag+'</span> ';
		$('#lsttags').css('display','').append(a);
		$('#tag').val(tag+addtag+',');		
	}	
function _removetag(a) {
		var tag = $('#tag').val();
		$('#tag').val(tag.replace(a+',',''));
		var add = '<span id="_tag" style="cursor: pointer;" onclick="_addtagdata(\''+a+'\');$(this).remove();" rel="'+a+'"><span class="state icon-newss"> </span> '+a+'</span> ';
		$('#_lsttag').append(add);
	}
function _showHide(a,b){
	if($('#'+a).css('display') == 'none'){
		$('#'+a).slideDown(800);
		$('#'+b).removeClass('icon-up');
		$('#'+b).addClass('icon-down');
		
	}else{
		$('#'+a).slideUp(800);
		$('#'+b).removeClass('icon-down');
		$('#'+b).addClass('icon-up');
	}
}	
	

