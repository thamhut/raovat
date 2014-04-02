<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @author Tham Nguyen Van
 * @copyright 2014
 */
class user extends MY_Controller {
    function init() {
		$this->load->library('Layouts');
        $this->load->model('user/user_model');
       
    }
    
    function index()
    {
        
    }
    
    function register()
    {
        $data = array();
        if(!isset($_POST['submit']))
        {
            $code = $this->setCacheCode();
            $data['code'] = $code['code'];
            $data['key'] = $code['key'];
        }
    	$data['headTitle'] = 'Gia nhập hệ thống';
        $data['bannername'] = 'dangki';
        if($this->input->post('submit'))
        {
            $data['errUser'] = $data['errPass'] = $data['errEmail'] = $data['errRePass'] = $data['errCode'] = '';
            $pass = $this->_pass($this->input->post());
            $data['set'] = $set = $this->_set($this->input->post());
            $data['errUser'] = $pass['errUser'];
			$data['errPass'] = $pass['errPass'];
			$data['errEmail'] = $pass['errEmail'];
			$data['errRePass'] = $pass['errRePass'];
            $data['errCode'] = $pass['errCode'];
            if($data['errUser']!='' || $data['errPass']!='' || $data['errEmail']!='' || $data['errRePass']!='' || $data['errCode'] != '')
            {
                $code = $this->setCacheCode();
                $data['code'] = $code['code'];
                $data['key'] = $code['key'];
            }
            if($data['errUser']=='' && $data['errPass']=='' && $data['errEmail']=='' && $data['errRePass']=='' && $data['errCode'] == '')
            {
                if($this->input->post('namecode')!= $set['incode'])
                {
                    $code = $this->setCacheCode();
                    $data['code'] = $code['code'];
                    $data['key'] = $code['key'];
                    $data['errCode'] = 'Nhập sai mã.';
                }
                else
                {
                    $this->user_model->insert_account($set['username'], $set['password'], $set['email']);
                    $data['done'] = 'Cập nhật thành công';
                }
            }
        }
        $this->layouts->view('/user/user_join_view', $data);
    }
    
    function login()
    {
        $data = array();
        $data['errUser'] = '';
        $data['headTitle'] = 'Đăng nhập hệ thống';
        $url = $this->input->get('url')?$this->input->get('url'):base_url();
        $data['bannername'] = 'dangki';
        if(isset($_POST['submit']))
        {
            $username = $this->input->post('username')?addslashes($this->input->post('username')):'';
            $password = $this->input->post('password')?addslashes($this->input->post('password')):'';
            $result = $this->user_model->check_login($username, md5($password));
            if($result!=0)
            {
                $data = getCacheUser('user');
                $data['username'] = $result['username'];
                $data['id'] = $result['id'];
                $data['email'] = $result['email'];
                $data['group'] = $result['group'];
                setCacheUser('user',$data);
                redirect($url);
            }
            else
            {
                $data['errUser'] = 'Tên đăng nhập hoặc mật khẩu không đúng';
            }
        }
        $this->layouts->view('/user/user_login_view', $data);
    }
    
    function updateinfo()
    {
        $data = array();
        $data['headTitle'] = 'Cập nhật thông tin';
        $data['bannername'] = 'dangki';
        $data['errUser'] = $data['errPass'] = $data['errEmail'] = $data['errRePass'] = $data['errCode'] = '';
        if(@getCacheUser('user'))
        {
            if(!isset($_POST['submit']))
            {
                $code = $this->setCacheCode();
                $data['code'] = $code['code'];
                $data['key'] = $code['key'];
            }
            $user = getCacheUser('user');
            $data['info'] = $result = $this->user_model->info_user($user['id']);
            if(isset($_POST['submit']))
            {
                $pass = $this->_pass_update_info($this->input->post(), $user['username'], $user['email']);
                $data['set'] = $set = $this->_set_update_info($this->input->post());
                $data['errUser'] = $pass['errUser'];
    			$data['errEmail'] = $pass['errEmail'];
                $data['errCode'] = $pass['errCode'];
                if($data['errUser']!='' || $data['errEmail']!='' || $data['errCode'] != '')
                {
                    $code = $this->setCacheCode();
                    $data['code'] = $code['code'];
                    $data['key'] = $code['key'];
                }
                if($data['errUser']=='' && $data['errCode']=='' && $data['errEmail']=='')
                {
                    if($this->input->post('namecode')!= $set['incode'])
                    {
                        $code = $this->setCacheCode();
                        $data['code'] = $code['code'];
                        $data['key'] = $code['key'];
                        $data['errCode'] = 'Nhập sai mã.';
                    }
                    else
                    {
                        $this->user_model->update_info($set['username'], $set['email'], $user['id']);
                        $data['done'] = 'Cập nhật thành công';
                    }
                }
            }
            $this->layouts->view('/user/user_update_account_view', $data);
        }
        else
        {
            $data['error'] = 'Không tồn tại nội dung!';
            $this->layouts->view('home/error_view',$data);
        }
    }
    
    function updatepass()
    {
        $data = array();
        $data['headTitle'] = 'Đổi mật khẩu';
        $data['bannername'] = 'dangki';
        if(@getCacheUser('user'))
        {
            $user = getCacheUser('user');
            $data['info'] = $result = $this->user_model->info_user($user['id']);
            if(isset($_POST['submit']))
            {
                $data['data'] = $pass = $this->_pass_update_pass($this->input->post(), $result['password']);
                $data['set'] = $set = $this->_set_update_pass($this->input->post());
                if($pass['errPass2']=='' && $pass['errPass3']=='' && $pass['errPass1']=='')
                {
                    $this->user_model->update_pass($set['pass2'], $user['id']);
                    $data['done'] = 'Cập nhật thành công';
                }
            }
            $this->layouts->view('/user/user_update_pass_view', $data);
        }
        else
        {
            $data['error'] = 'Không tồn tại nội dung!';
            $this->layouts->view('home/error_view',$data);
        }
    }
    
    function forgetpass()
    {
        $data = array();
        $data['headTitle'] = 'Gửi xác nhận';
        $data['errUser'] = '';$data['bannername'] = 'dangki';
        if(isset($_POST['submit']))
        {
            $post = $this->input->post();
            if($this->user_model->raovat_check_user_email_exit($post['email'],$post['username'])!=0 )
            {
                $code = md5($post['username'].$post['email']);
                $this->user_model->raovat_update_lostpass($post['username'], $code);
                $mail = $post['email'];
        		$cc_email = '';
        		$subject = 'Xác nhận mật khẩu';
                $message = 'Mở link sau và nhập mã xác nhận.<br />';
                $message .= base_url('user/changepass');
                $message .= ' <br />Mã xác nhận: '.$code;
        		sendMail($mail, $subject, $message,$cc_email);
                $data['send']='';
            }
            else
            {
                $data['errUser'] = "Tên đăng nhập hoặc email chưa đúng!";
            }
        }
        $this->layouts->view('/user/user_forget_pass_view', $data);
    }
    
    function changepass()
    {
        $data = array();
        $data['headTitle'] = 'Lấy lại mật khẩu';
        $data['errUser'] = '';$data['bannername'] = 'dangki';
        $data['errUser'] = $data['errPass'] = $data['errRePass'] = $data['errCode'] = '';
        if(isset($_POST['submit']))
        {
            $post = $this->input->post();
            $data['pass'] = $this->_pass_change_pass($post);
            $data['set'] = $this->_set_update_pass($post);
            $data['errUser'] = $data['pass']['errUser'];
            $data['errPass'] = $data['pass']['errPass'];
            $data['errRePass'] = $data['pass']['errRePass'];
            $data['errCode'] = $data['pass']['errCode'];
            if($data['pass']['errUser']=='' && $data['pass']['errPass']=='' && $data['pass']['errRePass']=='' && $data['pass']['errCode']=='')
            {
                if($this->user_model->raovat_check_user_code_exit($post['incode'], $post['username'])!=0)
                {
                    $this->user_model->update_pass_by_namecode($post['username'], $data['set']['pass2']);
                    $data['done']='';
                }
                else
                {
                    $data['err'] = "Chưa đúng hãy thử lại!";
                }
            }
            else
            {
                $data['err'] = "Chưa đúng hãy thử lại!";
            }
        }
        $this->layouts->view('/user/user_change_pass_view', $data);
    }
    
    function _pass_change_pass($post)
    {
        $data = array();
		$data['errUser'] = $data['errPass'] = $data['errRePass'] = $data['errCode'] = '';
        if($this->user_model->check_user_exit($post['username'])==0){
			$data['errUser'] = 'Tên đăng nhập chưa đúng.';
            return $data;
		}
        
        if($post['pass2'] == ''){
			$data['errPass'] = 'Bạn chưa nhập mật khẩu.';
            $data['ketqua'] = array('0','#password','Bạn chưa nhập mật khẩu.');
            return $data;
		}elseif(strlen($post['pass2']) < 6){
			$data['errPass'] = 'Mật khẩu quá ngắn.';
            return $data;
		}elseif($post['repassword'] == ''){
			$data['errRePass'] = 'Bạn chưa xác nhận mật khẩu.';
            return $data;
		}elseif($post['pass2'] != $post['repassword']){
			$data['errRePass'] = 'Xác nhận mật khẩu sai.';
            return $data;
		}
        
        if($post['incode'] == '')
        {
            $data['errCode'] = 'Bạn chưa nhập mã.';
            return $data;
        }
    }
    
    function _pass($post){
		$data = array();
		$data['errUser'] = $data['errPass'] = $data['errEmail'] = $data['errRePass'] = $data['errCode'] = '';
		
        if($post['username']==''){
			$data['errUser'] = 'Bạn chưa nhập tên đăng nhập.';
            return $data;
		} elseif(!$this->mycommon->validUsername($post['username'])){
			$data['errUser'] = "Tên đăng nhập không hợp lệ.";
            return $data;
		} elseif($this->user_model->check_user_exit($post['username'])!=0){
			$data['errUser'] = 'Tên đăng nhập đã tồn tại.';
            return $data;
		}
		
		if($post['password'] == ''){
			$data['errPass'] = 'Bạn chưa nhập mật khẩu.';
            $data['ketqua'] = array('0','#password','Bạn chưa nhập mật khẩu.');
            return $data;
		}elseif(strlen($post['password']) < 6){
			$data['errPass'] = 'Mật khẩu quá ngắn.';
            return $data;
		}elseif($post['repassword'] == ''){
			$data['errRePass'] = 'Bạn chưa xác nhận mật khẩu.';
            return $data;
		}elseif($post['password'] != $post['repassword']){
			$data['errRePass'] = 'Xác nhận mật khẩu sai.';
            return $data;
		}
		
		if($post['email'] == ''){
			$data['errEmail'] = 'Bạn chưa nhập email.';
            return $data;
		} elseif ( !$this->user_model->checkEmail($post['email'])){
			$data['errEmail'] = 'Email không hợp lệ.';
            return $data;
		} elseif ($this->user_model->check_email_exit($post['email'])!=0){
			$data['errEmail'] = 'Email đã tồn tại';
            return $data;
		}
        
        if($post['incode'] == '')
        {
            $data['errCode'] = 'Bạn chưa nhập mã.';
            return $data;
        }
	}
    
    function _set($post)
    {
		$post['username'] = addslashes($post['username']);
		$post['email'] = addslashes($post['email']);
		if(isset($post['submit'])){
			if($post['password']!='')$post['password'] = md5($post['password']);
		}
        $post['incode'] = md5(addslashes($post['incode']));
		return $post;
    }
    
    function _pass_update_info($post, $name, $email){
		$data = array();
		$data['errUser'] = $data['errPass'] = $data['errEmail'] = $data['errRePass'] = $data['errCode'] = '';
		
        if(trim($post['username']) != $name)
        {
            if($post['username']==''){
    			$data['errUser'] = 'Bạn chưa nhập tên đăng nhập.';
                return $data;
    		} elseif(!$this->mycommon->validUsername($post['username'])){
    			$data['errUser'] = "Tên đăng nhập không hợp lệ.";
                return $data;
    		} elseif($this->user_model->check_user_exit($post['username'])!=0){
    			$data['errUser'] = 'Tên đăng nhập đã tồn tại.';
                return $data;
    		}
        }
        
		if(trim($post['email']) != $email)
        {
            if($post['email'] == ''){
    			$data['errEmail'] = 'Bạn chưa nhập email.';
                return $data;
    		} elseif ( !$this->user_model->checkEmail($post['email'])){
    			$data['errEmail'] = 'Email không hợp lệ.';
                return $data;
    		} elseif ($this->user_model->check_email_exit($post['email'])!=0){
    			$data['errEmail'] = 'Email đã tồn tại';
                return $data;
    		}
        }
		
        
        if($post['incode'] == '')
        {
            $data['errCode'] = 'Bạn chưa nhập mã.';
            return $data;
        }
	}
    
    function _set_update_info($post)
    {
		$post['username'] = addslashes($post['username']);
		$post['email'] = addslashes($post['email']);
        $post['incode'] = md5(addslashes($post['incode']));
		return $post;
    }
    
    function _pass_update_pass($post, $pass){
		$data = array();
		$data['errPass1'] = $data['errPass2'] = $data['errPass3'] = '';
		
        if(md5($post['pass1'])!=$pass)
        {
            $data['errPass1'] = 'Mật khẩu cũ không đúng.';
            return $data;
        }
        else
        {
            if($post['pass2'] == ''){
    			$data['errPass2'] = 'Bạn chưa nhập mật khẩu.';
                return $data;
    		}elseif(strlen($post['pass2']) < 6){
    			$data['errPass2'] = 'Mật khẩu quá ngắn.';
                return $data;
    		}elseif($post['pass3'] == ''){
    			$data['errPass3'] = 'Bạn chưa xác nhận mật khẩu.';
                return $data;
    		}elseif($post['pass3'] != $post['pass2']){
    			$data['errPass3'] = 'Xác nhận mật khẩu sai.';
                return $data;
    		}
        }
	}
    
    function _set_update_pass($post)
    {
		if(isset($post['submit'])){
			if($post['pass2']!='')$post['pass2'] = md5($post['pass2']);
		}
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

?>