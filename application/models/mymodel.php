<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @author Nguyen Van Tham
 * @copyright 2014
 */
class Mymodel extends CI_Model{

	var $_db = null;
	
	function __construct() {
        $this->_db = & $this->db;
    }
	
	function __setDb(&$mydb = null)
	{
		$this->_db = $mydb;
	}
	
	function getRows($query, $multiRow = 1, $resultType = 'array')
	{
		$iconn = $this->_db->conn_id;
        mysqli_query($iconn,"SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
        mysqli_query($iconn, "set names 'utf8'"); 
		mysqli_multi_query($iconn, $query) or $this->mycommon->show_custom_error(mysqli_error($iconn));
		$result = mysqli_store_result($iconn);
		$data = array();
		$function = "mysqli_fetch_".$resultType;
		if($multiRow)
			while($row = $function($result))
			{
				$data[] = $row;
			}
		else $data = $function($result);
		
		mysqli_free_result($result);
		if(mysqli_more_results($iconn))
		{
			mysqli_next_result($iconn);
		}
		return $data;
	}
	
	function getRowsOnMultiQuery($query, $resultType = 'array')
	{
		$data = array();
		$function = "mysqli_fetch_".$resultType;
		
		$iconn = $this->_db->conn_id;
        mysqli_query($iconn,"SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
        mysqli_query($iconn, "set names 'utf8'"); 
		mysqli_multi_query($iconn, $query) or $this->mycommon->show_custom_error(mysqli_error($iconn));
		$i = 0;
		while (($result = mysqli_store_result($iconn)) !== false)
		{
			$data[$i] = array();
			while($row = $function($result))
			{
				$data[$i][] = $row;
			}
			$i++;
			if(!mysqli_next_result($iconn)) break;
		}
		
		if($result !== false) mysqli_free_result($result);
		if(mysqli_more_results($iconn))
		{
			mysqli_next_result($iconn);
		}
		return $data;
	}
	
	function exeQuery($query)
	{
		$iconn = $this->_db->conn_id;
        mysqli_query($iconn,"SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
        mysqli_query($iconn, "set names 'utf8'"); 
		mysqli_multi_query($iconn, $query) or $this->mycommon->show_custom_error(mysqli_error($iconn));
		if(mysqli_more_results($iconn))
		{
			mysqli_next_result($iconn);
		}
	}
	
	function getCache($query, $itemCache, $pathCache='')
	{
		$CI = & get_instance();
		if($CI->mycache->is_cached($itemCache, $pathCache)){
			$data = $CI->mycache->get_item($itemCache, $pathCache);
		}else{
			$data = $query;
			$CI->mycache->cache_item($itemCache, $data, $pathCache);
		}
		return $data;
	}
	function setCache($query, $itemCache, $pathCache='')
	{
		$CI = & get_instance();
		$CI->mycache->cache_item($itemCache, $query, $pathCache);
	}
	function delCache($itemCache, $pathCache='')
	{
		$CI = & get_instance();
		$CI->mycache->delete_item($itemCache, $pathCache);
	}
	
	function setCacheModule($itemId=0, $status=0)
	{
		if($itemId){
			$this->setCache($this->getRows("CALL nm_back_module_info($itemId);", 0), 'module_'.$itemId, 'module/');
		}else{
			$data = array();
			$result = $this->getRowsOnMultiQuery("CALL nm_back_module_getall($status);");
			$data = $result[0];
			foreach($data as $k){
				$this->setCacheModule($k['module_id']);
			}
			$this->setCache($this->getRowsOnMultiQuery("CALL nm_back_module_getall($status);"), 'modules_'.$status, 'module/');
		}
	}
	function getCacheModule($itemId=0, $status=0)
	{
		$CI = & get_instance();
		if($itemId){
			if($CI->mycache->is_cached('module_'.$itemId, 'module/')){
				$data = $CI->mycache->get_item('module_'.$itemId, 'module/');
			}else{
				$data = $this->getRows("CALL nm_back_module_info($itemId);", 0);
				$this->getCacheModule($itemId);
			}
			return $data;
		}else{
			if($CI->mycache->is_cached('modules_'.$status, 'module/')){
				$data = $CI->mycache->get_item('modules_'.$status, 'module/');
			}else{
				$data = $this->getRowsOnMultiQuery("CALL nm_back_module_getall($status);");
				$this->setCacheModule(0,$status);
			}
			return $data;
		}
	}
	
	function setCacheCategory($itemId=0)
	{
		if($itemId){
			$this->setCache($this->getRows("CALL nm_back_category_info($itemId);", 0), 'category_'.$itemId, 'category/');
		}else{
			$data = array();
			$result = $this->getRowsOnMultiQuery("CALL nm_back_category_getall(-1,'',0,-1,'',0,1000,'');");
			$data = $result[0];
			foreach($data as $k){
				$this->setCacheCategory($k['catid']);
			}
		}
	}
	function getCacheCategory($itemId=0)
	{
		$CI = & get_instance();
		if($itemId){
			if($CI->mycache->is_cached('category_'.$itemId, 'category/')){
				$data = $CI->mycache->get_item('category_'.$itemId, 'category/');
			}else{
				$data = $this->getRows("CALL nm_back_category_info($itemId);", 0);
				$this->setCacheCategory($itemId);
			}
			return $data;
		}
	}
	function setCacheType($itemId=0)
	{
		if($itemId){
			$this->setCache($this->getRows("CALL nm_back_type_info($itemId);", 0), 'type_'.$itemId, 'type/');
		}else{
			$data = array();
			$result = $this->getRowsOnMultiQuery("CALL nm_back_type_getall(-1,'',0,-1,'',0,1000,'');");
			$data = $result[0];
			foreach($data as $k){
				$this->setCacheType($k['catid']);
			}
		}
	}
	function getCacheType($itemId=0)
	{
		$CI = & get_instance();
		if($itemId){
			if($CI->mycache->is_cached('type_'.$itemId, 'type/')){
				$data = $CI->mycache->get_item('type_'.$itemId, 'type/');
			}else{
				$data = $this->getRows("CALL nm_back_type_info($itemId);", 0);
				$this->setCacheType($itemId);
			}
			return $data;
		}
	}
	
	function setCacheSetting()
	{
		$data = $_data = array();
		$data = $this->getRowsOnMultiQuery("CALL nm_back_setting();");
		foreach($data[0] as $k){
			$a = $k['setting_key'];
			$_data[$a] = $k['setting_value'];
		}
		$this->setCache($_data, 'setting', 'setting/');
	}
	function getCacheSetting()
	{
		$CI = & get_instance();
		$data = $_data = array();
		if($CI->mycache->is_cached('setting', 'setting/')){
			$_data = $CI->mycache->get_item('setting', 'setting/');
		}else{
			$data = $this->getRowsOnMultiQuery("CALL nm_back_setting();");
			foreach($data[0] as $k){
				$a = $k['setting_key'];
				$_data[$a] = $k['setting_value'];
			}
			$this->setCacheSetting();
		}
		return $_data;
	}
	
}