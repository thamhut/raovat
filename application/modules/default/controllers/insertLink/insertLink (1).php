<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
<?php
/**
 * @author Tham Nguyen Van
 * @copyright 2014
 */
include('simple_html_dom.php');
function my_callback_raovatvn($element) {
    if ($element->tag=='script')
        $element->outertext = '';
    if ($element->tag=='fb:comments')
        $element->outertext = '';
    
    if ($element->class=='key-ls')
        $element->outertext = '';
    if ($element->class=='titleDetail')
    $element->outertext = '';
    if ($element->class=='authorDetail')
    $element->outertext = '';
    if ($element->tag=='img')
    {
        if(strpos($element->src,'http')!==false)
        {
        }
        else 
        {
            $element->src = 'http://www.raovat.vn/'.$element->src;
        }
    }
}

function my_callback_raovatcom($element) {
    if ($element->tag=='img')
    {
        if(strpos($element->src,'http://raovat.com')!==false)
        {
        }
        else 
        {
            $element->src = 'http://raovat.com/'.$element->src;
        }
    }
    
}



class insertLink {
	function init() {
		//$this->load->library('Layouts');
        //$this->load->model('insertLink/insertLink_model');
    }
    function index() {
    	echo "a";
    }
    
    public function write($error){
        $file = "Log.txt";
        $handle = fopen($file, 'a'); //w
        fwrite($handle, $error."\n");
        fclose($handle);
    }
  /**
   * Đọc file trong PHP
   *   */
    public function read($file)
    {
        $link=array();
        $handle = fopen($file, 'r');
        while(!feof($handle))
        {
            $link[] = fgets($handle);
        }
        fclose($handle);
        return $link;
    }
      
    public function check($a,$b) 
    {
        if(strpos($a,$b)>=0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    function insert()
    {
        $link = $this->read('loadlink.txt');
        foreach($link as $item)
        {
            $cate = explode('()',$item);
            $this->loadcontent(trim($cate[1]),$cate[0]);
        }
        
    }
    
    function get_fcontentByGoogle($url) {
        $url = str_replace( "&amp;", "&", urldecode(trim($url)) );
        (function_exists('curl_init')) ? '' : die('cURL Must be installed. Ask your host to enable it or uncomment extension=php_curl.dll in php.ini');
        $curl = curl_init();
        $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
        $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        $header[] = "Keep-Alive: 300";
        $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $header[] = "Accept-Language: en-us,en;q=0.5";
        $header[] = "Pragma: ";
        
        curl_setopt($curl, CURLOPT_URL, $url);
        //curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_REFERER, 'http://www.google.com'); 
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        
        $html = curl_exec($curl);
        
        curl_close($curl);
        
        return $html;
    }
    
    function loadcontent_raovatvn($url)
    {
        $result = array();
        $data = $this -> get_fcontentByGoogle($url);
        $html = str_get_html($data);$en='';
        foreach($html->find('div#detailItem div.timeDetail strong') as $e)
        {
            $e1 = explode('-',$e);
            $e1 = str_replace( "</strong>", "", $e1[1]);
            $result['city'] = $this->getCity(trim($e1));
            
            //echo (trim($e1));
            break;
        }
        foreach($html->find('div#detailItem div.titleDetail h1') as $e)
        {
            $e = str_replace( "<h1>", "", $e);
            $e1 = str_replace( "</h1>", "", $e);
            $result['title'] = $e1;
        }
        foreach($html->find('div#detailItem div.authorDetail strong') as $e)
        {
            $e = str_replace( "<strong>", "", $e);
            $e1 = str_replace( "</strong>", "", $e);
           $result['lienhe'][] = $e1;
        }
        $html->set_callback('my_callback_raovatvn');
        
        foreach($html->find('div#detailItem div.m10') as $e)
        {
           $result['content'] = str_replace( "'", "\'", htmlentities($e));
        }
        
        foreach($html->find('div#detailItem div.m10 img') as $e)
        {
            $result['img'][] = $e->src;
        }
        return $result;
    }
    
    function loadcontent_raovatcom($url)
    {
        $data = $this->get_fcontentByGoogle($url);
        $html = str_get_html($data);
        $result = array();
        $arr = array();
        foreach($html->find('div#noidung_tin div.tinrao_list_chitiet_title') as $e)
        {
            $e = str_replace( '<div class="tinrao_list_chitiet_title">', "", $e);
            $e = str_replace( '</div>', "", $e);
           $result['title'] = $e;
        }
        
        foreach($html->find('div#noidung_tin div.tinrao_thongtindang') as $e)
        {
           $arr[] = htmlentities($e);
        }
        $alx = explode('Nơi rao', $arr[0]);
        $alx = explode('-', $alx[1]);
        $alx = explode(': ', $alx[0]);
        $result['city'] = $this->getCity(trim($alx[1]));
        
        foreach($html->find('div#noidung_tin div.tinrao_thongtindang strong') as $e)
        {
            $e = str_replace( "<strong>", "", $e);
            $e1 = str_replace( "</strong>", "", $e);
           $result['lienhe'][] = str_replace( "'", "\'", $e1);;
        }
        $html->set_callback('my_callback_raovatcom');
        foreach($html->find('div#tinrao_chitiet_tinrao ') as $e)
        {
           $result['content'] = str_replace( "'", "\'", htmlentities($e));
        }
        
        foreach($html->find('div#tinrao_chitiet_tinrao img') as $e)
        {
            $result['img'][] = $e->src;
        }
        return $result;
    }
    
    function loadcontent_jaovat($url)
    {
        $data = $this->get_fcontentByGoogle($url);
        $html = str_get_html($data);
        $result = array();
        foreach($html->find('div#olx_item_title div.h1') as $e)
        {
            $e = str_replace( '<div class="h1">', "", $e);
            $e = str_replace( '</div>', "", $e);
            $e = str_replace( '<small>', "", $e);
            $e = str_replace( '</small>', "", $e);
            $result['title'] = $e;
            $e = explode('—', $e);
            $result['city'] = $this->getCity(trim($e[1]));
        }
        foreach($html->find('div#item-desc') as $e)
        {
           $result['content'] = str_replace( "'", "\'", htmlentities($e));
        }
        foreach($html->find('div#galleryContainer img') as $e)
        {
            $result['img'][] = $e->src;
        }
        
        foreach($html->find('div#itm-table div.price strong') as $e)
        {
           $result['cost'] = $e;
        }
        /*foreach($html->find('div#item-info div.user-wrapper') as $e)
        {
           $result['lienhe'][0] = $e;
        }
        $arr = $html->find('ul#item-data li');
        $result['lienhe'][2] = $e;
        */
        foreach($html->find('ul#item-data li.phone strong') as $e)
        {
            $e = str_replace('<strong>', '', $e);
            $e = str_replace('</strong>', '', $e);
           $result['lienhe'] = $e;
        }
        return $result;
    }
    
    
    function loadcontent($url, $cate)
    {
        $date = date("Y-m-d H:i:s");
        $data = $this->get_fcontentByGoogle($url);
        $html = str_get_html($data);
        if(strpos($url,'raovat.vn')==11)
        {
            foreach($html->find('td.titleListDetail div.title a') as $e)
            {
                if($this->checkLink("http://www.raovat.vn".$e->href)!=0)
                {
                    $data2 = $this->loadcontent_raovatvn("http://www.raovat.vn".$e->href);
                    $content = isset($data2['content'])?$data2['content']:'';
                    $title = isset($data2['title'])?$data2['title']:'';
                    $city = isset($data2['city'])?$data2['city']:'';
                    $img = '';
                    /*if(isset($data2['img']))
                    {
                        $img = implode(',',$data2['img']);
                    }*/
                    if(isset($data2['lienhe'][1]))
                    {
                        $lienlac = ','.$data2['lienhe'][1].',,';
                    }
                    else
                    {
                        $lienlac = ',,,,';
                    }
                    $this->insertdb($url, "http://www.raovat.vn".$e->href, $date, 'raovat.vn', $cate, $content, 1, $title, $img, $city, $lienlac);
                }
            }
        }
        
        /*if(strpos($url,'raovat.com')==7)
        {
            $i=0;
            foreach($html->find('div.tinrao_list ul li a') as $e)
            {
               if($i%2==0)
               {
                    if($this->insertLink_model->checkLink("http://www.raovat.com".$e->href)!=0)
                    {
                        $data2 = $this->loadcontent_raovatcom("http://raovat.com/".$e->href) ;
                        $content = isset($data2['content'])?$data2['content']:'';
                        $title = isset($data2['title'])?$data2['title']:'';
                        $city = isset($data2['city'])?$data2['city']:'';
                        $img = '';
                        if(isset($data2['img']))
                        {
                            $img = implode(',',$data2['img']);
                        }
                        $lienlac ='';
                        $lienlac .= isset($data2['lienhe'][2])?$data2['lienhe'][2].',':',';
                        $lienlac .= ',';
                        if(isset($data2['lienhe'][3]))
                        {
                            $yahoo = explode('</a>',$data2['lienhe'][3]);
                            $lienlac .= isset($yahoo[1])?$yahoo[1].',':',';
                        }
                        else
                        {
                            $lienlac .= ',';
                        }
                        $lienlac .= isset($data2['lienhe'][4])?$data2['lienhe'][4]:'';
                        $this->insertdb($url, "http://raovat.com/".$e->href, $date, 'raovat.com', $cate, $content, 1, $title, $img, $city, $lienlac);
                    }
               }
               ++$i;
            }
        }
        if(strpos($url,'jaovat.com')==11)
        {
            foreach($html->find('div#itemListContent div.cropit a') as $e)
            {
                if($e)
                {
                    if($this->insertLink_model->checkLink($e->href)!=0)
                    {
                        $data2 = $this->loadcontent_jaovat($e->href) ;
                        $title = isset($data2['title'])?$data2['title']:'';
                        $city = isset($data2['city'])?$data2['city']:0;
                        //$img = '';
                        //if(isset($data2['img']))
                        //{
                        //    $img = implode(',',$data2['img']);
                        //}
                        $content = isset($data2['content'])?$data2['content']:'';
                        $lienlac = '';
                        if(isset($data2['lienhe']))
                        {
                            $lienlac = $data2['lienhe'].',,,,';
                        }
                        else
                        {
                            $lienlac = ',,,,';
                        }
                        //echo($data2['lienhe']);
                        
                        $this->insertdb($url, $e->href, $date, 'jaovat.com', $cate, $content, 1, $title, '', $city, $lienlac);
                    }
                }
            }
        }*/
    }
    
    function insertdb($url, $url_chil, $date, $source, $cate, $content, $uid, $title, $img, $address, $lienlac)
    {
        //$this->insertLink_model->insertLink($url, $url_chil, $date, $source, $cate, $content, $uid, $title, $img, $address, $lienlac);
        $query = "CALL raovat_insert_url('$url', '$url_chil', '$date', '$source', '$cate', '$content','$uid', '$title', '$img', '$address', '$lienlac');";
		$link = mysql_connect('localhost', 'root', '') ;
        mysqli_query($link, 'SET NAMES utf8' );
		mysql_select_db("raovatdb", $link);
		$result = mysql_query($query, $link);
    }
    
    function checkLink($url)
    {
        $query = "CALL raovat_check_url_insert('$url');";
		$link = mysql_connect('localhost', 'root', '') ;
        mysqli_query($link, 'SET NAMES utf8' );
		mysql_select_db("raovatdb", $link);
		$result = mysql_query($query, $link);
        return $result;
    }
    
    function getCity($city)
    {
        $ms=0;
        switch(trim($city))
        {
            case 'Toàn quốc': $ms=0; break;
            case 'Việt Nam': $ms=0; break;
            case 'Cao Bằng': $ms=11; break;
            case 'Lạng Sơn': $ms=12; break;
            case 'Hà Bắc': $ms=13; break;
            case 'Quảng Ninh': $ms=14; break;
            case 'Hải Phòng': $ms=16; break;
            case 'Thái Bình': $ms=17; break;
            case 'Nam Định': $ms=18; break;
            case 'Phú Thọ': $ms=19; break;
            case 'Thái Nguyên': $ms=20; break;
            case 'Yên Bái': $ms=21; break;
            case 'Tuyên Quang': $ms=22; break;
            case 'Hà Giang': $ms=23; break;
            case 'Lào Cai': $ms=24; break;
            case 'Lai Châu': $ms=25; break;
            case 'Sơn La': $ms=26; break;
            case 'Điện Biên': $ms=27; break;
            case 'Hòa Bình': $ms=28; break;
            case 'Hà Nội': $ms=30; break;
            case 'Hà Tây': $ms=33; break;
            case 'Hải Dương': $ms=34; break;
            case 'Ninh Bình': $ms=35; break;
            case 'Thanh Hóa': $ms=36; break;
            case 'Nghệ An': $ms=37; break;
            case 'Hà Tĩnh': $ms=38; break;
            case 'Đà Nẵng': $ms=43; break;
            case 'Đắc Lắc': $ms=47; break;
            case 'Đắk Lắk': $ms=47; break;
            case 'Lâm Đồng': $ms=49; break;
            case 'TP HCM': $ms=55; break;
            case 'Tp.HCM': $ms=55; break;
            case 'Tp Hồ Chí Minh': $ms=55; break;
            case 'Đồng Nai': $ms=60; break;
            case 'Bình Dương': $ms=61; break;
            case 'Long An': $ms=62; break;
            case 'Tiền Giang': $ms=63; break;
            case 'Vĩnh Long': $ms=64; break;
            case 'Cần Thơ': $ms=65; break;
            case 'Đồng Tháp': $ms=66; break;
            case 'An Giang': $ms=67; break;
            case 'Kiên Giang': $ms=68; break;
            case 'Cà Mau': $ms=69; break;
            case 'Tây Ninh': $ms=70; break;
            case 'Bến Tre': $ms=71; break;
            case 'Vũng Tàu': $ms=72; break;
            case 'Quảng Bình': $ms=73; break;
            case 'Quảng Trị': $ms=74; break;
            case 'Huế': $ms=75; break;
            case 'Quảng Ngãi': $ms=76; break;
            case 'Bình Định': $ms=77; break;
            case 'Phú Yên': $ms=78; break;
            case 'Khánh Hòa': $ms=79; break;
            case 'Gia Lai': $ms=81; break;
            case 'Kon Tum': $ms=82; break;
            case 'Sóc Trăng': $ms=83; break;
            case 'Trà Vinh': $ms=84; break;
            case 'Ninh Thuận': $ms=85; break;
            case 'Bình Thuận': $ms=86; break;
            case 'Vĩnh Phúc': $ms=88; break;
            case 'Hưng Yên': $ms=89; break;
            case 'Quảng Nam': $ms=92; break;
            case 'Bình Phước': $ms=93; break;
            case 'Bạc Liêu': $ms=94; break;
            case 'Bắc Kạn': $ms=97; break;
            case 'Bắc Giang': $ms=98; break;
            case 'Bắc Ninh': $ms=99; break;
        }
        return $ms;
    }
    
}

?>

<?php
$a=new insertLink;
$a->insert();
?>