<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @author Tham Nguyen Van
 * @copyright 2014
 */
class news_model extends Mymodel
{
    function insert_content($tite, $img, $content, $iduser, $idcate, $date, $city, $lienlac)
    {
        //print_r($tite);die();
        $result = $this->getRows("CALL raovat_insert_content('$tite', '$img', '$content', '$iduser', '$idcate', '$date', '$city', '$lienlac');");
        return isset($result[0])?$result[0]:0;
    }
    
    function get_content_update($id)
    {
        $result = $this->getRowsOnMultiQuery("CALL raovat_get_info_news('$id');");
        $data = array();
        $data['content'] = $result[0];
        $data['cate'] = $result[1];
        return $data;
    }
    
    function raovat_update_content($id, $tite, $img, $content, $iduser, $idcate, $date, $city, $lienlac)
    {
        $this->exeQuery("CALL raovat_update_content('$id', '$tite', '$img', '$content', '$iduser', '$idcate', '$date', '$city', '$lienlac');");
    }
    
    function raovat_getnews_byuser($iduser, $start, $numrow, $cate=-1, $city=-1, $keyword='')
    {
        $result = $this->getRowsOnMultiQuery("CALL raovat_getnews_byuser('$iduser', '$start', '$numrow', '$cate', '$city', '$keyword');");
        $data = array();
        $data['lstItem'] = $result[0];
        $data['num'] = $result[1];
        return $data;
    }
}
?>