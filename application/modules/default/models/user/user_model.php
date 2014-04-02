<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @author Tham Nguyen Van
 * @copyright 2014
 */
class user_model extends Mymodel
{
    function checkEmail($email) {
    	$this->load->helper('email');
    	if(valid_email($email))
    	{
    		return true;
    	}
    	return false;
    }
    
    function check_user_exit($username)
    {
        $result = $this->getRows("CALL raovat_check_user_exit('','$username');");
        return $result[0][0];
    }
    
    function check_email_exit($email)
    {
        $result = $this->getRows("CALL raovat_check_user_exit('$email','');");
        return $result[0][0];
    }
    
    function insert_account($username, $password, $email)
    {
        $date = date('Y-m-d H:i:s');
        $group = 2013;
        $this->exeQuery("CALL raovat_register_account('$username','$password', '$email', '$date', '$group');");
    }
    
    function check_login($username, $password)
    {
        $result = $this->getRows("CALL raovat_check_login('$username','$password');");
        if(isset($result[0]))
        {
            return $result[0];
        }
        else
        {
            return 0;
        }
    }
    
    function info_user($id)
    {
        $result = $this->getRows("CALL raovat_get_info_user('$id');");
        if(isset($result[0]))
        {
            return $result[0];
        }
        else
        {
            return 0;
        }
    }
    
    function update_info($username, $email, $id)
    {
        $this->exeQuery("CALL raovat_update_info('$username', '$email', '$id');");
    }
    
    function update_pass($pass, $id)
    {
        $this->exeQuery("CALL raovat_update_pass('$pass', '$id');");
    }
    
    function raovat_check_user_email_exit($email, $user)
    {
        $result = $this->getRows("CALL raovat_check_user_exit('$email','');");
        return $result?$result[0][0]:0;
    }
    
    function update_pass_by_namecode($name, $code)
    {
        $this->exeQuery("CALL raovat_update_pass_by_namecode('$name', '$code');");
    }
    
    function raovat_check_user_code_exit($code, $name)
    {
        $result = $this->getRows("CALL raovat_check_user_code_exit('$code','$name');");
        return $result?$result[0][0]:0;
    }
    
    function raovat_update_lostpass($name, $code)
    {
        $this->exeQuery("CALL raovat_update_lostpass('$name', '$code');");
    }
    
}
?>