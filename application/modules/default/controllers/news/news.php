<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @author Tham Nguyen Van
 * @copyright 2014
 */
class news extends MY_Controller {
	function init() {
		$this->load->library('Layouts');
        $this->load->model('news/news_model');
        
        if(@getCacheUser('user'))
        {
            $this->userid = getCacheUser('user');
            $this->userid = $this->userid['id'];
        }
        else
        {
            $this->userid = 1;
        }
    }
    
    function index()
    {
        $data = array();
        $data['bannername'] = 'dangtin';
    	$data['headTitle'] = 'Đăng tin miễn phí';
        $data['errTitle'] = $data['errCode'] = '';
        if(!isset($_POST['submit']))
        {
            $code = $this->setCacheCode();
            $data['code'] = $code['code'];
            $data['key'] = $code['key'];
        }
        else
        {
            $Ym = date('Ym', time()).'/';
            $d = $Ym.date('d', time()).'/';
            $uploaddir = DT_ROOT . '/'. IMGPATH . $Ym;
            $uploadurl = base_url() . IMGPATH . $d;
            if (!@is_dir($uploaddir)){
                if( ! @mkdir($uploaddir, DIR_WRITE_MODE)){
                @chmod($uploaddir, DIR_WRITE_MODE);
                }
            }
            $uploaddir = DT_ROOT . '/'. IMGPATH . $d;
            if (!@is_dir($uploaddir)){
                if( ! @mkdir($uploaddir, DIR_WRITE_MODE)){
                    @chmod($uploaddir, DIR_WRITE_MODE);
                }
            }
            $valid_formats = array("jpg", "png", "gif", "jpeg");
            $max_file_size = 1024*1000; //1000 kb
            $path = ""; // Upload directory
            $count = 0;
            $newfile = array();
            if(isset($_POST['submit']) and $_SERVER['REQUEST_METHOD'] == "POST"){
                // Loop $_FILES to exeicute all files
                foreach ($_FILES['img']['name'] as $f => $name) {     
                    if ($_FILES['img']['error'][$f] == 4) {
                        continue; // Skip file if any error found
                    }	       
                    if ($_FILES['img']['error'][$f] == 0) {	           
                        if ($_FILES['img']['size'][$f] > $max_file_size) {
                            $message[$f] = "File is quá lớn!.";
                            continue; // Skip large files
                        }
                    	elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
                    		$message[$f] = "Sai định dạng";
                    		continue; // Skip invalid file formats
                    	}
                        else{ // No error found! Move uploaded files 
                            $type = explode('/',$_FILES['img']['type'][$f]);
                            if(move_uploaded_file($_FILES["img"]["tmp_name"][$f], $uploaddir.md5($name).'.'.$type[1]))
                            $count++; // Number of successfully uploaded file
                            $newfile[] = $uploadurl.md5($name).'.'.$type[1];
                        }
                    }
                }
                $path = implode(',',$newfile);
            }
            
            $pass = $this->pass($this->input->post());
            $data['set'] = $set = $this->set($this->input->post());
            $data['errTitle'] = $pass['errTitle'];
            $data['errCode'] = $pass['errCode'];
            if($data['errTitle'] == '' && $data['errCode'] =='')
            {
                if($this->input->post('namecode') != ($set['incode']))
                {
                    $code = $this->setCacheCode();
                    $data['code'] = $code['code'];
                    $data['key'] = $code['key'];
                    $data['errCode'] = 'Nhập sai mã.';
                }
                else
                {
                    $lienlac = $set['sdt'].','.$set['email'].','.$set['yahoo'].','.$set['skype'];
                    $data['done'] = $this->news_model->insert_content($set['title'], $path, $set['content'], $this->userid, $this->input->post('catelv'), date('Y-m-d H:i:s'), $this->input->post('city'), $lienlac);
                    $title = $this->mycommon->getStringCut($set['title']);
                    redirect(site_url('detail/'.$title.'_i'.$data['done']['idinsert']));
                }
            }
            else
            {
                $code = $this->setCacheCode();
                $data['code'] = $code['code'];
                $data['key'] = $code['key'];
            }
            $data['submit'] = '';
            $data['cate'] = $this->input->post('cate');
            $data['catelv'] = $this->input->post('catelv');
        }
        $arrcity = array();
        $j=0;
        for($i=0; $i<100; ++$i)
        {
            if(getCity($i)!='')
            {
                $arrcity[$j]['ms'] = $i;
                $arrcity[$j]['city'] = getCity($i);
                $j++;
            }
        }
        $data['city'] = $arrcity;
        $this->layouts->view('/news/upload_news_view',$data);
    }
    
    function deleteContent()
    {
        $this->load->model('manager/manager_model');
        $id = $this->input->get('id')?$this->input->get('id'):0;
        $content = $this->home_model->getContentById($id);
        $cpage = is_numeric($this->input->get('cpage'))?(int)($this->input->get('cpage')):1;
        $city= is_numeric($this->input->get('city'))?(int)($this->input->get('city')):-1;
        $cate= is_numeric($this->input->get('cate'))?(int)($this->input->get('cate')):-1;
        if($this->userid == $content['id_user'])
        {
            $this->manager_model->delete_content_byid($id);
            redirect(base_url('news/mynews').'?cpage='.$cpage.'&city='.$city.'&cate='.$cate.'&msg=Xóa thành công');
        }
    }
    
    function newsinfo()
    {
        $data = array();
        $data['bannername'] = 'dangtin';
    	$data['headTitle'] = 'Cập nhật tin đăng';
        $data['errTitle'] = $data['errCode'] = '';
        $id = $this->input->get('id')?$this->input->get('id'):0;
        if(!isset($_POST['submit']))
        {
            $code = $this->setCacheCode();
            $data['code'] = $code['code'];
            $data['key'] = $code['key'];
        }
        else
        {
            $resultUpdate = $this->update($id,$this->input->post(), $_FILES['img']);
            if($resultUpdate['errTitle'] == '' && $resultUpdate['errCode'] == '')
            {
                $title = $this->mycommon->getStringCut($resultUpdate['set']['title']);
                redirect(site_url('detail/'.$title.'_i'.$id));
            }
            else
            {
                $data['msg'] = $resultUpdate;
                $code = $this->setCacheCode();
                $data['code'] = $code['code'];
                $data['key'] = $code['key'];
            }
        }
        $result = $this->news_model->get_content_update($id);
        $data['content'] = $content = $result['content'][0];
        $data['cate'] = $result['cate'][0];
        $data['img'] = explode(',',$content['img']);
        $data['lienhe'] = explode(',',$content['lienlac']);
        $arrcity = array();
        $j=0;
        for($i=0; $i<100; ++$i)
        {
            if(getCity($i)!='')
            {
                $arrcity[$j]['ms'] = $i;
                $arrcity[$j]['city'] = getCity($i);
                $j++;
            }
        }
        $data['city'] = $arrcity;
        $this->layouts->view('/news/upload_news_update_view',$data);
    }
    
    function update($id, $post, $file)
    {
        $data = array();
        $data['errTitle'] = $data['errCode'] = '';
        $Ym = date('Ym', time()).'/';
        $d = $Ym.date('d', time()).'/';
        $uploaddir = DT_ROOT . '/'. IMGPATH . $Ym;
        $uploadurl = base_url() . IMGPATH . $d;
        if (!@is_dir($uploaddir)){
            if( ! @mkdir($uploaddir, DIR_WRITE_MODE)){
            @chmod($uploaddir, DIR_WRITE_MODE);
            }
        }
        $uploaddir = DT_ROOT . '/'. IMGPATH . $d;
        if (!@is_dir($uploaddir)){
            if( ! @mkdir($uploaddir, DIR_WRITE_MODE)){
                @chmod($uploaddir, DIR_WRITE_MODE);
            }
        }
        $valid_formats = array("jpg", "png", "gif", "jpeg");
        $max_file_size = 1024*1000; //1000 kb
        $path = ""; // Upload directory
        $count = 0;
        $newfile = array();
        if(isset($_POST['submit'])){
            // Loop $_FILES to exeicute all files
            foreach ($file['name'] as $f => $name) {     
                if ($file['error'][$f] == 4) {
                    continue; // Skip file if any error found
                }	       
                if ($file['error'][$f] == 0) {	           
                    if ($file['size'][$f] > $max_file_size) {
                        $message[$f] = "File is quá lớn!.";
                        continue; // Skip large files
                    }
                	elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
                		$message[$f] = "Sai định dạng";
                		continue; // Skip invalid file formats
                	}
                    else{ // No error found! Move uploaded files 
                        $type = explode('/',$file['type'][$f]);
                        if(move_uploaded_file($file["tmp_name"][$f], $uploaddir.md5($name).'.'.$type[1]))
                        $count++; // Number of successfully uploaded file
                        $newfile[] = $uploadurl.md5($name).'.'.$type[1];
                    }
                }
            }
            $path = implode(',',$newfile);
        }
        if(isset($post['img']))
        {
            $img = $post['img'];
            $img = implode(',',$img);
        }
        else
        {
            $img ='';
        }
        $pass = $this->pass($post);
        if($path!='')
        {
            $path = $path.','.$img;
        }
        else
        {
            $path = $img;
        }
        $data['set'] = $set = $this->set($post);
        $data['errTitle'] = $pass['errTitle'];
        $data['errCode'] = $pass['errCode'];
        if($data['errTitle'] == '' && $data['errCode'] =='')
        {
            if($post['namecode'] != ($set['incode']))
            {
                $data['errCode'] = 'Nhập sai mã.';
            }
            else
            {
                $lienlac = $set['sdt'].','.$set['email'].','.$set['yahoo'].','.$set['skype'];
                if($id!=0)
                {
                    $this->news_model->raovat_update_content($id, $set['title'], $path, $set['content'], $this->userid, $post['catelv'], date('Y-m-d H:i:s'), $post['city'],$lienlac);
                }
            }
        }
        return ($data);
    }
    
    function mynews()
    {
        $data = array();
    	$data['headTitle'] = 'Danh sách tin đăng';
        $data['bannername'] = 'dangtin';
        $user = getCacheUser('user');
        $data['iduser'] = $iduser = isset($user['id'])?$user['id']:0;
        $data['cpage'] = $cPage = $this->input->get('cpage')? $this->input->get('cpage'):1;
        $data['cate'] = $cate = is_numeric($this->input->get('cate'))? (int)$this->input->get('cate'):-1;
        $data['selectcity'] = $city = is_numeric($this->input->get('city'))? (int)$this->input->get('city'):-1;
        $data['keyword'] = $this->input->get('keyword')? $this->input->get('keyword'):'';
        $data['keyword'] = $keyword = preg_replace('/[`|~|!|@|#|%|^|&|*|(|)||=|\[|\]|{|}|\'|"|;||?||>||<|,|\\|\||“]+/i', '',$data['keyword']);
        $cPage = (is_numeric($cPage) && $cPage > 0) ? $cPage : 1;
		$start = ($cPage - 1) * 50;
        $result = $this->news_model->raovat_getnews_byuser($iduser, $start,$this->numrow, $cate,$city,$keyword);
        $data['num'] = $result['num'];
        $data['lstItem'] = $result['lstItem'];
        $date_city = array();
        foreach($result['lstItem'] as $item)
        {
            $date_city[$item['id']]['date'] = $this->mycommon->subdate(date("Y-m-d H:i:s"),$item['date']);
            $date_city[$item['id']]['city'] = getCity($item['city']);
            $date_city[$item['id']]['title_convert'] = $this->mycommon->getStringCut($item['title']);
            $date_city[$item['id']]['img'] = isset($item['img'])?explode(',', $item['img']):'';
        }
        $data['date_city'] = $date_city;
        $data['numCurrItem'] = count($data['lstItem']);//ceil
        $data['pCount'] = ceil($result['num'][0][0]/50) ;
        $data['numItem'] = $numItem = 50;
        $data['lstPaging'] = $this->mycommon->getListPaging($cPage, $data['pCount']);
        $data['cpage'] = $cPage;
        $arrcity = array();
        $j=0;
        for($i=0; $i<100; ++$i)
        {
            if(getCity($i)!='')
            {
                $arrcity[$j]['ms'] = $i;
                $arrcity[$j]['city'] = getCity($i);
                $j++;
            }
        }
        $data['city'] = $arrcity;
    	$this->layouts->view('/news/list_news_view',$data);
    }
    
    function pass($post)
    {
        $data = array();
		$data['errTitle'] = $data['errCode'] = '';
        if(trim($post['title'])=='')
        {
            $data['errTitle'] = 'Bạn chưa nhập tiêu đề.';
            return $data;
        }
        if(trim($post['incode'])=='')
        {
            $data['errCode'] = 'Bạn chưa nhập mã.';
            return $data;
        }
    }
    
    function set($post)
    { 
        /*$post['title'] = htmlentities(($post['title']));
		$post['incode'] = md5(addslashes($post['incode']));
        $post['sdt'] = is_numeric($post['sdt'])?htmlentities($post['sdt']):'';
        $post['email'] = htmlentities(($post['email']));
        $post['yahoo'] = htmlentities(($post['yahoo']));
        $post['skype'] = htmlentities(($post['skype']));
        $post['content'] = htmlentities($post['content']);*/
        $post['title'] = addslashes(($post['title']));
		$post['incode'] = md5(addslashes($post['incode']));
        $post['sdt'] = addslashes($post['sdt'])?($post['sdt']):'';
        $post['email'] = addslashes(($post['email']));
        $post['yahoo'] = addslashes(($post['yahoo']));
        $post['skype'] = addslashes(($post['skype']));
        $post['content'] = addslashes($post['content']);
        return $post;
    }
    
    function setCacheCode()
    {
        $data = array();
        deletecode('');
        $acode=getcode();
        $data['key'] = implode('',$acode['key']);
        foreach($acode['value'] as $item)
        {
            $arr['code'][] = $item;
        }
        $data['code'] = $arr['code'];
        return $data;
    }
}