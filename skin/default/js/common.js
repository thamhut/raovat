var BASE_URL = 'http://'+location.host+'/';
function abc(e)
{
    var id=0;
    var arrType = ["image/gif", "image/jpeg", "image/jpg", "image/png"];
    var file = document.getElementById(e.id);
    console.log(file.files);
    if(arrType.indexOf(file.files[0].type)==-1)
    {
        alert("Sai định dạng.");
            return false;
    }
    else if(file.files[0].size>1000000)
    {
        alert("File quá lớn định dạng.");
            return false;
    }
    else if($(".div_choise_img").length<5)
    {
        var arrid = e.id.split("-");
        id = parseInt(arrid[1])+1;
        $("tr#"+e.id+"-tr").after('<tr class="tr_choise_img" id="div_choise_img-'+id+'-tr"><td> <div><input class="div_choise_img" id="div_choise_img-'+id+'" onchange="abc(this);" type="file" name="img[]" id="file" /></div></td></tr>');
    }

    $('#'+e.id+'-tr div').css('background','#FFFFFF');
    $('#'+e.id).css('opacity','1');
}

function choisecate(id)
{
    $("#lst_cate").css('display','none');
    $("#input_data_new, #danhgia").css('display','inline-block');
    $("input#input_choise_lvcate").val(id);
    $("#span_choise_lvcate")[0].innerHTML = $("#_"+id+" a")[0].innerHTML;
}

function changecate()
{
    $("#lst_cate").css('display','inline-block');
    $("#input_data_new, #danhgia").css('display','none');
}

function sendemail()
{
    var emailgui = 'thamhut@gmail.com';
    var faqsend = $("#mail_message").val().trim();
    
    $.ajax({
        type: "POST",
        url: BASE_URL+"home/sendmail",
        data: { email_send: emailgui, mess_send: faqsend },
        success:function( msg ) {
            alert( msg );
        }
    });
    return false;
}

function deleteImg(i)
{
    if($(".div_choise_img").length==6)
    {
        $("tr.tr_choise_img").show();
    }
    $("#div_choise_img-"+i+"-tr").remove();
}

function deleted_news()
{
    return confirm('Bạn có muốn xóa tin đăng này?')
}

function find_news()
{
    window.location = BASE_URL+'news/mynews?keyword='+$(".input_keyword").val();
}

function findnews()
{
    var param = $("input#input_find").val();
    window.location.href = BASE_URL+'home/searchnews?q='+param;
}