<?php
    header("Content-type: text/html; charset=utf-8");
    include 'simple_html_dom.php';
    function my_callback_raovatvn($element) {
        if ($element->tag=='script')
            $element->outertext = '';
        if ($element->tag=='fb:comments')
            $element->outertext = '';
        if ($element->tag=='xml')
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
                if(strpos($element->src,'http')!=0)
                {
                    $element->src = 'http://www.raovat.vn/'.$element->src;
                }
            }
            else 
            {
                $element->src = 'http://www.raovat.vn/'.$element->src;
            }
        }
    }
    
    function my_callback_raovatcom($element) {
        if ($element->tag=='xml')
        $element->outertext = '';
        if ($element->tag=='img')
        {
            if(strpos($element->src,'http')!==false)
            {
                if(strpos($element->src,'http')!=0)
                {
                    $element->src = 'http://raovat.com/'.$element->src;
                }
            }
            else 
            {
                $element->src = 'http://raovat.com/'.$element->src;
            }
        }
    }
    
    function write($error){
        $file = "Log.txt";
        $handle = fopen($file, 'a'); //w
        fwrite($handle, $error."\n");
        fclose($handle);
    }
    
    function read($file)
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
          
    function check($a,$b) 
    {
        if(strpos($a,$b)!==false)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    function insert($source)
    {
        $link = read('loadlink.txt');
        foreach($link as $item)
        {
            $cate = explode('()',$item);
            if(check(trim($cate[1]), $source))
            {
               loadcontent(trim($cate[1]),$cate[0]);
            }
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
        $data = get_fcontentByGoogle($url);
        $html = str_get_html($data);$en='';
        foreach($html->find('div#detailItem div.timeDetail strong') as $e)
        {
            $e1 = explode('-',$e);
            $e1 = str_replace( "</strong>", "", $e1[1]);
            $result['city'] = getCity(trim($e1));
            
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
            $e = preg_replace('#<div(.*?)>#i', '', $e);
            $e = str_replace('</div>', '', $e);
            //$e = preg_replace('#<script.*?</script>#s', '', $e);
            $result['content'] = $e;
        }
        
        $i=0;
        foreach($html->find('div#detailItem div.m10 img') as $e)
        {
            if($i<5)
            {
                $result['img'][] = $e->src;
            }
            $i++;
        }
        return $result;
    }
        
    function loadcontent_raovatcom($url)
    {
        $data = get_fcontentByGoogle($url);
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
        $result['city'] = getCity(trim($alx[1]));
        
        foreach($html->find('div#noidung_tin div.tinrao_thongtindang strong') as $e)
        {
            $e = str_replace( "<strong>", "", $e);
            $e1 = str_replace( "</strong>", "", $e);
           $result['lienhe'][] = str_replace( "'", "\'", $e1);;
        }
        $html->set_callback('my_callback_raovatcom');
        foreach($html->find('div#tinrao_chitiet_tinrao ') as $e)
        {
            $e = preg_replace('#<div(.*?)>#i', '', $e);
            $e = str_replace('</div>', '', $e);
            $result['content'] = $e;
        }
        
        $i=0;
        foreach($html->find('div#tinrao_chitiet_tinrao img') as $e)
        {
            if($i<5)
            {
                $result['img'][] = $e->src;
            }
            $i++;
        }
        return $result;
    }
        
    function loadcontent_jaovat($url)
    {
        $data = get_fcontentByGoogle($url);
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
            $result['city'] = getCity(trim($e[1]));
        }
        foreach($html->find('div#item-desc') as $e)
        {
            $e = preg_replace('#<div(.*?)>#i', '', $e);
            $e = str_replace('</div>', '', $e);
            $e = preg_replace('#<script.*?</script>#s', '', $e);
            $result['content'] = $e;
        }
        
        $i=0;
        foreach($html->find('div#galleryContainer img') as $e)
        {
            if($i<5)
            {
                $result['img'][] = $e->src;
            }
            $i++;
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
        $data = get_fcontentByGoogle($url);
        $html = str_get_html($data);
        if(strpos($url,'raovat.vn')==11)
        {
            foreach($html->find('td.titleListDetail div.title a') as $e)
            {
                $check = checkLink("http://www.raovat.vn".$e->href);
                if($check[0]==0)
                {
                    $data2 = loadcontent_raovatvn("http://www.raovat.vn".$e->href);
                    $content = isset($data2['content'])?$data2['content']:'';
                    $title = isset($data2['title'])?$data2['title']:'';
                    $city = isset($data2['city'])?$data2['city']:'';
                    $img = '';
                    if(isset($data2['img']))
                    {
                        $img = implode(',',$data2['img']);
                    }
                    if(isset($data2['lienhe'][1]))
                    {
                        $lienlac = ','.$data2['lienhe'][1].',,';
                    }
                    else
                    {
                        $lienlac = ',,,,';
                    }
                    if($title!=''){
                        insertdb($url, "http://www.raovat.vn".$e->href, $date, 'raovat.vn', $cate, addslashes($content), 2, addslashes($title), $img, $city, $lienlac);
                    }
                }
            }
        }
        if(strpos($url,'raovat.com')==7)
        {
            $i=0;
            foreach($html->find('div.tinrao_list ul li a') as $e)
            {
               if($i%2==0)
               {
                    if(checkLink("http://raovat.com/".$e->href)!=0)
                    {
                        $data2 = loadcontent_raovatcom("http://raovat.com/".$e->href) ;
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
                        if($title!=''){
                            insertdb($url, "http://raovat.com/".$e->href, $date, 'raovat.com', $cate, addslashes($content), 2, addslashes($title), $img, $city, $lienlac);
                        }
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
                    if(checkLink($e->href)!=0)
                    {
                        $data2 = loadcontent_jaovat($e->href) ;
                        $title = isset($data2['title'])?$data2['title']:'';
                        $city = isset($data2['city'])?$data2['city']:0;
                        $img = '';
                        if(isset($data2['img']))
                        {
                            $img = implode(',',$data2['img']);
                        }
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
                        if($title!=''){
                            insertdb($url, $e->href, $date, 'jaovat.com', $cate, addslashes($content), 2, addslashes($title), '', $city, $lienlac);
                        }
                    }
                }
            }
        }
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
    
    function checkLink($url)
    {
        $query = "CALL raovat_check_url_insert('$url');";
        $iconn = mysqli_connect('localhost', 'chotam_thamhut', 'trietquyendao', 'chotam_raovat') or die('Eo ket noi duoc') ;
        mysqli_multi_query($iconn, $query) ;
		$result = mysqli_store_result($iconn);
		$data = array();
		$function = "mysqli_fetch_array";
		$data = $function($result);
		
		mysqli_free_result($result);
		if(mysqli_more_results($iconn))
		{
			mysqli_next_result($iconn);
		}
		return $data;
    }
    
    function insertdb($url, $url_chil, $date, $source, $cate, $content, $uid, $title, $img, $address, $lienlac)
    {
        //print_r($url.','.$url_chil.','.$date.','.$source.','.$cate.',$content,'.$uid.','.$title.','.$img.','.$address.','.$lienlac);
        //insertLink($url, $url_chil, $date, $source, $cate, $content, $uid, $title, $img, $address, $lienlac);
        $data = array();
        $query = "CALL raovat_insert_url('$url', '$url_chil', '$date', '$source', '$cate', '$content','$uid', '$title', '$img', '$address', '$lienlac');";
        $function = "mysqli_fetch_array";
		
		$iconn = mysqli_connect('localhost', 'chotam_thamhut', 'trietquyendao', 'chotam_raovat') ;
        mysqli_query($iconn, 'SET NAMES utf8' );
        mysqli_query($iconn,"SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'") or die($url_chil);
		mysqli_multi_query($iconn, $query) ;
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
    
    
    //abc();
    
?>