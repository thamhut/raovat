<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @author Tham Nguyen Van
 * @copyright 2014
 */
class manager_model extends Mymodel
{
    function delete_content_byid($id)
    {
        $this->exeQuery("CALL raovat_delete_content_byid('$id');");
    }
    
    function delete_content_bymonth($date)
    {
        $this->exeQuery("CALL raovat_delete_content_bymonth('$date');");
    }
    
    function update_cate($name, $id_level, $name1)
    {
        $this->exeQuery("CALL update_cate('$name', '$id_level', '$name1');");
    }
    
    function getall_user_register($start, $numrow)
    {
        $result = $this->getRowsOnMultiQuery("CALL raovat_getall_user('$start', '$numrow')");
        $data = array();
        $data['lstUser'] = isset($result[0])?$result[0]:array();
        $data['num'] = isset($result[1])?$result[1]:0;
        return $data;
    }
    
    function raovat_login_byuser($id)
    {
        $result = $this->getRows("CALL raovat_login_byuser('$id');");
        if(isset($result[0]))
        {
            return $result[0];
        }
        else
        {
            return 0;
        }
    }
    
    function raovat_delete_user_byid($id)
    {
        $this->exeQuery("CALL raovat_delete_user_byid('$id');");
    }
}
?>