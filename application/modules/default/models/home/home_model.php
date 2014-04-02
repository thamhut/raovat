<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @author Tham Nguyen Van
 * @copyright 2014
 */
class home_model extends Mymodel
{
	function getCateAll()
    {
        return $this->getRows('CALL raovat_getall_category();');
    }
    
    function getall_content($start, $numrow)
    {
        return $this->getRows("CALL raovat_getall_content('$start','$numrow');");
    }
    
    function getCateByIdlevel($idlevel, $page=1, $numrow=50, $city=0)
    {
        $result = $this->getRowsOnMultiQuery("CALL raovat_get_category_byidlevel('$idlevel', '$page', '$numrow', '$city');");
        $data = array();
        $data['lstCate'] = isset($result[0])?$result[0]:array();
        $data['lstContent'] = isset($result[1])?$result[1]:array();
        $data['name1'] = isset($result[2])?$result[2]:'';
        $data['name2'] = isset($result[3])?$result[3]:'';
        $data['num'] = isset($result[4])?$result[4]:'';
        return $data;
    }
    
    function getContentById($idContent)
    {
        $result = $this->getRows("CALL raovat_getcontent_byid('$idContent');");
        return isset($result[0])?$result[0]:0;
    }
    
    
    function getall_category()
    {
        return $this->getRows("CALL raovat_getall_category();");
    }
    
 }