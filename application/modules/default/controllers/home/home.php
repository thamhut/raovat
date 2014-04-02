<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @author Tham Nguyen Van
 * @copyright 2014
 */
class home extends MY_Controller {
	function init() {
		$this->load->library('Layouts');
        $this->city = @getCacheUser('city')?getCacheUser('city'):0;
    }
    function index() {
    	$data = array();
        $data['bannername'] = '';
    	$data['headTitle'] = 'Trang chủ';
        $data['cate'] = $this->home_model->getCateAll();
        $data['news'] = $this->home_model->getall_content(0,7);
        foreach($data['news'] as $item)
        {
            $data['title'][$item['id']]['title_convert'] = $this->mycommon->getStringCut($item['title']);
        }
    	$this->layouts->view('/home/home_view',$data);
    }
    
    function choise_city()
    {
        $url = $this->input->get('url')?$this->input->get('url'):base_url('');
        $city = $this->input->get('city');
        $data['ms_city'] = $city;
        $data['name_city'] = $this->getCity($city);
        setCacheUser('city',$data);
        redirect($url);
    }
    
    function category($id=0)
    {
        $data = array();
    	
        $data['id'] = $id;
        $data['cpage'] = $cPage = $this->input->get('cpage')? $this->input->get('cpage'):1;
        $cPage = (is_numeric($cPage) && $cPage > 0) ? $cPage : 1;
		$start = ($cPage - 1) * 50;
        $result = $this->home_model->getCateByIdlevel($id, $start,50,$this->city['ms_city']);
        $data['catelevel'] = $result['lstCate'];
        $data['lstContent'] = $result['lstContent'];
        $date_city = array();
        foreach($result['lstContent'] as $item)
        {
            $date_city[$item['id']]['date'] = $this->mycommon->subdate(date("Y-m-d H:i:s"),$item['date']);
            $date_city[$item['id']]['city'] = $this->getCity($item['city']);
            $date_city[$item['id']]['title_convert'] = $this->mycommon->getStringCut(html_entity_decode($item['title']));
            $date_city[$item['id']]['img'] = isset($item['img'])?explode(',', $item['img']):'';
        }
        $data['numCurrItem'] = count($data['lstContent']);//ceil
        $data['pCount'] = isset($result['num'][0][0])?ceil($result['num'][0][0]/50):1 ;
        $data['numItem'] = $numItem = 50;
        $data['lstPaging'] = $this->mycommon->getListPaging($cPage, $data['pCount']);
        $data['cPage'] = $cPage;
        $data['date_city'] = $date_city;
        if(isset($result['name1'][0][0]))
        {
            $data['headTitle'] = $result['name1'][0][0];
        }
        else
        {
            $data['headTitle'] = 'Danh mục';
        }
        
        $data['name1'] = isset($result['name1'][0][0])?$result['name1'][0][0]:'';
        $data['name2'] = isset($result['name2'][0][0])?$result['name2'][0][0]:'';
        $data['bannername'] = $this->mycommon->getStringCut($data['name1']);
        $name1 = $this->mycommon->getStringCut($data['name1']);
        $name2 = $this->mycommon->getStringCut($data['name2']);
        $data['meta'] = $name1.'_'.$name2;
        $data['meta_content'] = str_replace('_', ' ', $data['meta']);
        $data['meta_title'] = $data['meta_content'];
    	$this->layouts->view('/home/category_view',$data);
    }
    
    function category_level($id=0)
    {
        $data = array();
    	
    	$data['headTitle'] = 'Publisher Admirco';
    	$this->layouts->view('/home/category_view',$data);
    }
    
    function detail($id=0)
    {
        $data = array();
        $data['content'] = $this->home_model->getContentById($id);
    	$data['bannername'] = '';
        if($data['content']!=0)
        {
            $data['headTitle'] = $data['content']['title'];
            if(isset($data['content']['img']))
            {
                $data['content']['img'] = explode(',',$data['content']['img']) ;
            }
            else
            {
                for($i=0; $i<5; ++$i)
                $data['content']['img'][] = '';
            }
            $data['city'] = $this->getCity($data['content']['city']);
            $data['lienlac'] = explode(',',$data['content']['lienlac']);
            $data['date_detail'] = $this->mycommon->subdate(date("Y-m-d H:i:s"),$data['content']['date']);
            $result = $this->home_model->getCateByIdlevel($data['content']['id_category'], 0, 10, $this->city['ms_city']);
            $data['lstContent'] = $result['lstContent'];
            $date_city = array();
            foreach($result['lstContent'] as $item)
            {
                $date_city[$item['id']]['date'] = $this->mycommon->subdate(date("Y-m-d H:i:s"),$item['date']);
                $date_city[$item['id']]['city'] = $this->getCity($item['city']);
                $date_city[$item['id']]['title_convert'] = $this->mycommon->getStringCut($item['title']);
                $date_city[$item['id']]['img'] = isset($item['img'])?explode(',', $item['img']):array('','','');
            }
            $data['date_city'] = $date_city;
            $data['meta_content'] = enhtml($data['content']['title']);
            $data['meta_title'] = enhtml($data['content']['title']);
            $this->layouts->view('/home/detail_view',$data);
        }
    	else
        {
            $data['error'] = 'Không tồn tại nội dung!';
            $this->layouts->view('home/error_view',$data);
        }
    }
    
    function sendmail()
    {
        if($this->input->post('email_send') == ''){
			echo "Bạn chưa nhập email.";
		} else{
			$mail = 'thamhut@gmail.com';
    		$cc_email = '';
    		$subject = 'Ý kiến đóng góp';
            $message = $this->input->post('mess_send');
    		sendMail($mail, $subject, $message,$cc_email);
            echo "Cảm ơn bạn đã gửi ý kiến.";
		}
        
    }
    
    function searchnews()
    {
        $keyword = $this->input->get('q')?$this->input->get('q'):'';
        $keyword = $this->mycommon->getStringCut($keyword);
        $keyword = 'chotam.info_'.$keyword;
        $keyword = str_replace('_','+', $keyword);
        redirect('https://www.google.com.vn/#q='.$keyword);
    }
    
    function getCity($city)
    {
        $ms='';
        switch(trim($city))
        {
            case 0: $ms='Toàn quốc'; break;
            case 11: $ms='Cao Bằng'; break;
            case 12: $ms='Lạng Sơn'; break;
            case 13: $ms='Hà Bắc'; break;
            case 14: $ms='Quảng Ninh'; break;
            case 16: $ms='Hải Phòng'; break;
            case 17: $ms='Thái Bình'; break;
            case 18: $ms='Nam Định'; break;
            case 19: $ms='Phú Thọ'; break;
            case 20: $ms='Thái Nguyên'; break;
            case 21: $ms='Yên Bái'; break;
            case 22: $ms='Tuyên Quang'; break;
            case 23: $ms='Hà Giang'; break;
            case 24: $ms='Lào Cai'; break;
            case 25: $ms='Lai Châu'; break;
            case 26: $ms='Sơn La'; break;
            case 27: $ms='Điện Biên'; break;
            case 28: $ms='Hòa Bình'; break;
            case 30: $ms='Hà Nội'; break;
            case 33: $ms='Hà Tây'; break;
            case 34: $ms='Hải Dương'; break;
            case 35: $ms='Ninh Bình'; break;
            case 36: $ms='Thanh Hóa'; break;
            case 37: $ms='Nghệ An'; break;
            case 38: $ms='Hà Tĩnh'; break;
            case 43: $ms='Đà Nẵng'; break;
            case 47: $ms='Đắc Lắc'; break;
            case 49: $ms='Lâm Đồng'; break;
            case 55: $ms='TP HCM'; break;
            case 60: $ms='Đồng Nai'; break;
            case 61: $ms='Bình Dương'; break;
            case 62: $ms='Long An'; break;
            case 63: $ms='Tiền Giang'; break;
            case 64: $ms='Vĩnh Long'; break;
            case 65: $ms='Cần Thơ'; break;
            case 66: $ms='Đồng Tháp'; break;
            case 67: $ms='An Giang'; break;
            case 68: $ms='Kiên Giang'; break;
            case 69: $ms='Cà Mau'; break;
            case 70: $ms='Tây Ninh'; break;
            case 71: $ms='Bến Tre'; break;
            case 72: $ms='Vũng Tàu'; break;
            case 73: $ms='Quảng Bình'; break;
            case 74: $ms='Quảng Trị'; break;
            case 75: $ms='Huế'; break;
            case 76: $ms='Quảng Ngãi'; break;
            case 77: $ms='Bình Định'; break;
            case 78: $ms='Phú Yên'; break;
            case 79: $ms='Khánh Hòa'; break;
            case 81: $ms='Gia Lai'; break;
            case 82: $ms='Kon Tum'; break;
            case 83: $ms='Sóc Trăng'; break;
            case 84: $ms='Trà Vinh'; break;
            case 85: $ms='Ninh Thuận'; break;
            case 86: $ms='Bình Thuận'; break;
            case 88: $ms='Vĩnh Phúc'; break;
            case 89: $ms='Hưng Yên'; break;
            case 92: $ms='Quảng Nam'; break;
            case 93: $ms='Bình Phước'; break;
            case 94: $ms='Bạc Liêu'; break;
            case 97: $ms='Bắc Kạn'; break;
            case 98: $ms='Bắc Giang'; break;
            case 99: $ms='Bắc Ninh'; break;
        }
        return $ms;
    }
}
