<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @author Tham Nguyen Van
 * @copyright 2014
 */
class manager extends MY_Controller {
    function init() {
		$this->load->library('Layouts');
        $this->load->model('manager/manager_model');
        $this->user = getCacheUser('user');
        $this->iduser = $this->user['id'];
        $this->group = $this->user['group'];
    }
    
    function index()
    {
        $data = array();
    	$data['headTitle'] = 'Quản lý';
        $data['bannername'] = 'dangtin';
        if(isset($this->iduser) && $this->group == '2008')
        {
            $data['id'] = $id = $this->input->get('id')?$this->input->get('id'):1;
            $data['cpage'] = $cPage = $this->input->get('cpage')? $this->input->get('cpage'):1;
            $cPage = (is_numeric($cPage) && $cPage > 0) ? $cPage : 1;
    		$start = ($cPage - 1) * 50;
            $result = $this->home_model->getCateByIdlevel($id, $start,50);
            $data['catelevel'] = $result['lstCate'];
            $data['lstContent'] = $result['lstContent'];
            $date_city = array();
            foreach($result['lstContent'] as $item)
            {
                $date_city[$item['id']]['date'] = $this->mycommon->subdate(date("Y-m-d H:i:s"),$item['date']);
                $date_city[$item['id']]['city'] = 'NA';
                $date_city[$item['id']]['title_convert'] = $this->mycommon->getStringCut($item['title']);
            }
            $data['numCurrItem'] = count($data['lstContent']);
            $data['pCount'] = ceil($result['num'][0][0]/50) +1;
            $data['numItem'] = $numItem = 50;
            $data['lstPaging'] = $this->mycommon->getListPaging($cPage, $data['pCount']);
            $data['cPage'] = $cPage;
            $data['date_city'] = $date_city;
            $data['lstcate'] = $this->home_model->getall_category();
            $this->layouts->view('manager/manager_view', $data);
        }
        else
        {
            $data['error'] = 'Bạn không có quyền truy cập!';
            $this->layouts->view('home/error_view',$data);
        }
    }
    
    function usermanager()
    {
        $data = array();
    	$data['headTitle'] = 'Quản lý';
        $data['bannername'] = 'dangki';
        $data['cpage'] = $cPage = $this->input->get('cpage')? $this->input->get('cpage'):1;
        $cPage = (is_numeric($cPage) && $cPage > 0) ? $cPage : 1;
		$start = ($cPage - 1) * 50;
        if(isset($this->iduser) && $this->group == '2008')
        {
            $result = $this->manager_model->getall_user_register($start,50);
            $data['lstUser'] = $result['lstUser'];
            $data['pCount'] = ceil($result['num'][0][0]/50) +1;
            $data['numCurrItem'] = count($data['lstUser']);
            $data['numItem'] = $numItem = 50;
            $data['lstPaging'] = $this->mycommon->getListPaging($cPage, $data['pCount']);
            $data['cPage'] = $cPage;
            $this->layouts->view('manager/user_manager_view', $data);
        }
        else
        {
            $data['error'] = 'Bạn không có quyền truy cập!';
            $this->layouts->view('home/error_view',$data);
        }
    }
    
    function loginbyuser()
    {
        $id = is_numeric($this->input->get('id'))?$this->input->get('id'):0;
        if(isset($this->iduser) && $this->group == '2008')
        {
            $result = $this->manager_model->raovat_login_byuser($id);
            if($result!=0)
            {
                $data = getCacheUser('user');
                $data['username'] = $result['username'];
                $data['id'] = $result['id'];
                $data['email'] = $result['email'];
                $data['group'] = $result['group'];
                setCacheUser('user',$data);
                redirect(base_url('home'));
            }
        }
    }
    
    function deleteuser()
    {
        $id = is_numeric($this->input->get('id'))?$this->input->get('id'):0;
        if(isset($this->iduser) && $this->group == '2008')
        {
            $result = $this->manager_model->raovat_delete_user_byid($id);
            redirect(base_url('manager/usermanager'));
        }
    }
    
    function deleteContent()
    {
        $id = $this->input->get('id')?$this->input->get('id'):0;
        $numItem = $this->input->get('numItem')?$this->input->get('numItem'):50;
        $cpage = $this->input->get('cpage')?$this->input->get('cpage'):1;
        if($this->group == '2008')
        {
            $this->manager_model->delete_content_byid($id);
            redirect(base_url('manager').'?v=0&numItem='.$numItem.'&cpage='.$cpage);
        }
    }
    
    function deleteContentByMonth()
    {
        if($this->group == '2008')
        {
            $date = date('Y-m-d', strtotime ( '-30 day' , strtotime (date('Y-m-d'))));
            $this->manager_model->delete_content_bymonth($date);
            echo 'Xóa thành công';
        }
    }
    
    function run()
    {
        $output = shell_exec('C:\xampp\php\php.exe E:\www\Copy_thamhut@gmail.com\raovat.cohet.vn\application\modules\default\controllers\insertLink');
        echo $output ;
    }
    
    function category()
    {
        $data = array();
        if($this->group == '2008')
        {
            $data['lstcate'] = $this->home_model->getCateAll();
            $id = ($this->input->post('id'));
            $id_level = ($this->input->post('id_level'));
            $name = ($this->input->post('name'));
            $name1 = ($this->input->post('name1'));
            if($this->input->post('submit'))
            {
                for($i=0; $i<count($id) ; $i++)
                {
                    //echo $name[$i])).'<br>';
                    $this->manager_model->update_cate((addslashes($name[$i])), (addslashes($id_level[$i])), (addslashes($name1[$i])));
                }
            }
            $this->layouts->view('manager/category_view', $data);
        }
        else
        {
            $data['error'] = 'Bạn không có quyền truy cập!';
            $this->layouts->view('home/error_view',$data);
        }
    }
    
}