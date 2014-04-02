<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @author Tham Nguyen Van
 * @copyright 2014
 */
class insertLink_model extends Mymodel
{
    function insertLink($_url, $_url_chil,  $_date, $_source , $_cate, $content, $uid=1, $title, $img='', $address, $lienlac)
    {
        
        return $this->getRowsOnMultiQuery("CALL raovat_insert_url('$_url', '$_url_chil', '$_date', '$_source', '$_cate', '$content','$uid', '$title', '$img', '$address', '$lienlac');");
    }
    
    
    
    function getallCate()
    {
        print_r($this->getRows("CALL raovat_getall_category('1');"));
    }
    
    function checkLink($url)
    {
        return $this->getRows("CALL raovat_check_url_insert('$url');");
    }
}