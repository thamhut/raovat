<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Anh Nguyen <duyanhnguyen@vccorp.vn>
 * @copyright 2012
 * @property Phpmailer $phpmailer PHP Mailer
 */
class Mycommon
{

    private $_CI;

    public function __construct()
    {
        $this->_CI = & get_instance();
    }

    public function loadMail()
    {
        $this->_CI->config->load('email');
        $config = $this->_CI->config->item('mail');
        $this->_CI->load->library('PHPMailer/phpmailer');
        $this->_CI->phpmailer->IsSMTP();
        $this->_CI->phpmailer->SMTPAuth = true;
        $this->_CI->phpmailer->SMTPSecure = $config['SMTPSecure'];
        $this->_CI->phpmailer->Host = $config['host'];
        $this->_CI->phpmailer->Port = $config['port'];
        $this->_CI->phpmailer->Username = $config['username'];
        $this->_CI->phpmailer->Password = $config['password'];
        $this->_CI->phpmailer->SetFrom($config['username'], $config['contentFrom']);
        $this->_CI->phpmailer->CharSet = $config['charset'];
    }
    
    function subdate($d1, $d2)
    {
        $today1 = date("m",strtotime($d1));  
        $today2 = date("m",strtotime($d2));
        $ketqua = array();
        if(date("m",strtotime($d1))==date("m",strtotime($d2)) && date("d",strtotime($d1)) - date("d",strtotime($d2))<7)
        {
            $ketqua['d'] = (date("d",strtotime($d1)) - date("d",strtotime($d2)));
            $ketqua['h'] = (date("H",strtotime($d1)) - date("H",strtotime($d2)));
            $ketqua['i'] = (date("i",strtotime($d1)) - date("i",strtotime($d2)));
            return $ketqua;
        }
        else
        {
            return 0;
        }
    }

    function isYoutube($url, $type = "videoUrl")
    {
        switch (strtolower($type)) {
            case "videourl" :
                $regex = "https?:\/\/(www.)?youtube.com\/watch\?v=[a-zA-Z0-9\_\-\.]{2,}&?(.*)?";
                break;
            case "channelurl" :
                $regex = "https?:\/\/(www.)?youtube.com\/user\/[a-zA-Z0-9\_\-\.]{2,}\/videos(\?.*)?";
                break;
            case "channeluploads" :
                $regex = "https?:\/\/gdata.youtube.com\/feeds\/(api|base)\/users\/[a-zA-Z0-9\_\-\.]{2,}\/uploads\/?(.*)?";
                break;
            case "playlist" :
                $regex = "https?:\/\/www.youtube.com\/playlist\?list=[a-zA-Z0-9\_\-\.]{18}&?(.*)?";
                break;
            case "playlistrss" :
                $regex = "https?:\/\/gdata.youtube.com\/feeds\/api\/playlists\/[a-zA-Z0-9\_\-\.]{16}\/?";
                break;
        }
        return preg_match("/$regex/i", $url);
    }

    function isUrl($input)
    {
        return preg_match("/^[A-Za-z]+:\/\/[A-Za-z0-9-_]+\\.[A-Za-z0-9-_%&\?\/.=#]+$/", $input);
    }

    public function _parseVidYoutube($url)
    {
        $regex = "/https?:\/\/(www.)?youtube.com\/watch\?v=([a-zA-Z0-9\_\-\.]{2,})&?(.*)?/i";
        $matches = array();
        preg_match($regex, $url, $matches);
        return $matches[2];
    }

    public function getThumbVideoYoutube($url)
    {
        if ($this->isYoutube($url)) {
            $vId = $this->_parseVidYoutube($url);
            $numImg = rand(1, 4);
            return "http://img.youtube.com/vi/$vId/$numImg.jpg";
        }
        return false;
    }

    public function getEmbedVideoYoutube($url)
    {
        $tmpSize = unserialize(VIDEO_SIZE);
        $videoSize = $tmpSize['normal'];
        if ($this->isYoutube($url)) {
            $vId = $this->_parseVidYoutube($url);
            return "<object width='{$videoSize['width']}' height='{$videoSize['height']}'>
                        <param name='movie' value='http://www.youtube.com/v/$vId?version=3&amp;hl=en_US'></param>
                        <param name='allowFullScreen' value='true'></param>
                        <param name='allowscriptaccess' value='always'></param>
                        <embed src='http://www.youtube.com/v/$vId?version=3&amp;hl=en_US' type='application/x-shockwave-flash' width='{$videoSize['width']}' height='{$videoSize['height']}' allowscriptaccess='always' allowfullscreen='true'></embed>
                    </object>";
        }
        return false;
    }

    public function authAdmin()
    {
        if (!$this->_CI->session->userdata('u_id') || !$this->_CI->session->userdata('u_acc')) {
            $back = site_url($this->_CI->uri->uri_string());
            $back = str_replace('.html', '', $back);
            $backlink = urlencode($back);
            header('Location: ' . site_url('admin/auth') . '?back_url=' . $backlink);
        }
    }

    function rangeWeek($datestr)
    {
        date_default_timezone_set(date_default_timezone_get());
        $dt = strtotime($datestr);
        $res['start'] = date('N', $dt) == 1 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('last monday', $dt));
        $res['end'] = date('N', $dt) == 7 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('next sunday', $dt));
        return $res;
    }

    public function renderThumbImage($image, $width, $height, $cropFlag = TRUE)
    {
        if (empty($image) || is_null($image)) {
            $image = '';
        }

        if ($image == '') {
            $image = '/images/noImage/no.jpg';
        }

        if ($cropFlag == TRUE) {
            return STATIC_DOMAIN . 'slir/w' . $width . '-h' . $height . '-c' . $width . 'x' . $height . $image;
        } else {
            return STATIC_DOMAIN . 'slir/w' . $width . '-h' . $height . $image;
        }
//        if ($cropFlag == TRUE) {
//            return STATIC_DOMAIN . 'timthumb.php?w=' . $width . '&h=' . $height . '&q=100' . '&src=' . $image;
//        } else {
//            return STATIC_DOMAIN . 'timthumb.php?w=' . $width . '&h=' . $height . '&src=' . $image;
//        }
    }

    public function getLangCode()
    {
        return 'vietnam';
    }

    public function setLangCode($lang)
    {
        $langValid = array(
            'vietnam',
            'english'
        );
        if (!in_array($lang, $langValid)) {
            return false;
        }
        $this->_CI->session->set_userdata('langCode', $lang);
        $this->_CI->load->library('Blockcache');
        $this->_CI->blockcache->save('menubar', '', 0);
        return true;
    }

    public function fetchLangCode($lang)
    {
        $arr = array(
            'vietnam' => 'vn',
            'english' => 'en'
        );
        if (!in_array($lang, array_keys($arr))) {
            return false;
        }
        return $arr[$lang];
    }



    function objectsIntoArray($arrObjData, $arrSkipIndices = array())
    {
        $arrData = array();

        // if input is object, convert into array
        if (is_object($arrObjData)) {
            $arrObjData = get_object_vars($arrObjData);
        }

        if (is_array($arrObjData)) {
            foreach ($arrObjData as $index => $value) {
                if (is_object($value) || is_array($value)) {
                    $value = $this->objectsIntoArray($value, $arrSkipIndices); // recursive call
                }
                if (in_array($index, $arrSkipIndices)) {
                    continue;
                }
                $arrData[$index] = $value;
            }
        }
        return $arrData;
    }

    public function initMailer()
    {
        $this->_CI->load->library('PHPMailer/phpmailer');
        $this->_CI->load->config('email');
        $config = $this->_CI->config->item('mail');
        $this->_CI->phpmailer->IsSMTP();
        $this->_CI->phpmailer->SMTPDebug = 0;
        $this->_CI->phpmailer->SMTPAuth = true;
        $this->_CI->phpmailer->SMTPSecure = 'ssl';
        $this->_CI->phpmailer->Host = $config['host'];
        $this->_CI->phpmailer->Port = $config['port'];
        $this->_CI->phpmailer->Username = $config['username'];
        $this->_CI->phpmailer->Password = $config['password'];
        $this->_CI->phpmailer->CharSet = 'utf-8';
        $this->_CI->phpmailer->SetFrom($config['username'], $config['contentFrom']);
        $this->_CI->phpmailer->AddAddress($config['adminEmail']);
    }

    public function resetCache($dir)
    {
        $documentRoot = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR;
        $files = scandir($documentRoot . $dir);
        $notDelete = array('.', '..', '.htaccess', 'index.html');
        foreach ($files as $file) {
            if(!in_array($file, $notDelete))
                @unlink($documentRoot . $dir . DIRECTORY_SEPARATOR . $file);
        }
    }
	//hongnn dung
	function show_custom_error($mess = '')
	{
		$CI =& get_instance();
		if (class_exists('CI_DB') AND isset($CI->db))
		{
			$CI->db->close();
		}
		die($mess);
	}

	//hongnn bat dau them
	function convertToAlias($title)
    {
        $title = htmlspecialchars_decode(trim($title));
        $strFind = array(
            ': ', ':',
            ' ',
            'đ', 'Đ',
            'á', 'à', 'ạ', 'ả', 'ã', 'Á', 'À', 'Ạ', 'Ả', 'Ã', 'ă', 'ắ', 'ằ', 'ặ', 'ẳ', 'ẵ', 'Ă', 'Ắ', 'Ằ', 'Ặ', 'Ẳ', 'Ẵ', 'â', 'ấ', 'ầ', 'ậ', 'ẩ', 'ẫ', 'Â', 'Ấ', 'Ầ', 'Ậ', 'Ẩ', 'Ẫ',
            'ó', 'ò', 'ọ', 'ỏ', 'õ', 'Ó', 'Ò', 'Ọ', 'Ỏ', 'Õ', 'ô', 'ố', 'ồ', 'ộ', 'ổ', 'ỗ', 'Ô', 'Ố', 'Ồ', 'Ộ', 'Ổ', 'Ỗ', 'ơ', 'ớ', 'ờ', 'ợ', 'ở', 'ỡ', 'Ơ', 'Ớ', 'Ờ', 'Ợ', 'Ở', 'Ỡ',
            'é', 'è', 'ẹ', 'ẻ', 'ẽ', 'É', 'È', 'Ẹ', 'Ẻ', 'Ẽ', 'ê', 'ế', 'ề', 'ệ', 'ể', 'ễ', 'Ê', 'Ế', 'Ề', 'Ệ', 'Ể', 'Ễ',
            'ú', 'ù', 'ụ', 'ủ', 'ũ', 'Ú', 'Ù', 'Ụ', 'Ủ', 'Ũ', 'ư', 'ứ', 'ừ', 'ự', 'ử', 'ữ', 'Ư', 'Ứ', 'Ừ', 'Ự', 'Ử', 'Ữ',
            'í', 'ì', 'ị', 'ỉ', 'ĩ', 'Í', 'Ì', 'Ị', 'Ỉ', 'Ĩ',
            'ý', 'ỳ', 'ỵ', 'ỷ', 'ỹ', 'Ý', 'Ỳ', 'Ỵ', 'Ỷ', 'Ỹ'
        );
        $strReplace = array(
            '-', '-',
            '-',
            'd', 'd',
            'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
            'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
            'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
            'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
            'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i',
            'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y'
        );

        return strtolower(preg_replace('/[^a-z0-9\- _]+/i', '', str_replace($strFind, $strReplace, $title)));
    }
	function converToUrl($url){
		$url = $this->convertToAlias($url);
		$url = str_replace('html', '', $url);
		return strtolower(preg_replace('/[^a-z]+/i', '', $url));
	}
	function converToGenerator($text){
		return strtolower(str_replace('.', 'dot', $text));
	}
	function convertToTags($title,$url=''){
		$title = htmlspecialchars_decode(trim($title));
		$str = explode(',',$title);
		$tags = '';
		foreach($str as $v){
			if($v)$tags .= ', <a href="'.site_url(str_replace(' ', '+', strtolower(trim($v))).'_'.$url.'t').'" title="Tag: '.ucfirst(trim($v)).'">'.ucfirst(trim($v)).'</a>';
		}
		return substr($tags,1);
	}
	function convertToKeyword($title){
		$title = htmlspecialchars_decode(trim($title));
        $strFind = array(
            ': ', ':',
            'đ', 'Đ',
            'á', 'à', 'ạ', 'ả', 'ã', 'Á', 'À', 'Ạ', 'Ả', 'Ã', 'ă', 'ắ', 'ằ', 'ặ', 'ẳ', 'ẵ', 'Ă', 'Ắ', 'Ằ', 'Ặ', 'Ẳ', 'Ẵ', 'â', 'ấ', 'ầ', 'ậ', 'ẩ', 'ẫ', 'Â', 'Ấ', 'Ầ', 'Ậ', 'Ẩ', 'Ẫ',
            'ó', 'ò', 'ọ', 'ỏ', 'õ', 'Ó', 'Ò', 'Ọ', 'Ỏ', 'Õ', 'ô', 'ố', 'ồ', 'ộ', 'ổ', 'ỗ', 'Ô', 'Ố', 'Ồ', 'Ộ', 'Ổ', 'Ỗ', 'ơ', 'ớ', 'ờ', 'ợ', 'ở', 'ỡ', 'Ơ', 'Ớ', 'Ờ', 'Ợ', 'Ở', 'Ỡ',
            'é', 'è', 'ẹ', 'ẻ', 'ẽ', 'É', 'È', 'Ẹ', 'Ẻ', 'Ẽ', 'ê', 'ế', 'ề', 'ệ', 'ể', 'ễ', 'Ê', 'Ế', 'Ề', 'Ệ', 'Ể', 'Ễ',
            'ú', 'ù', 'ụ', 'ủ', 'ũ', 'Ú', 'Ù', 'Ụ', 'Ủ', 'Ũ', 'ư', 'ứ', 'ừ', 'ự', 'ử', 'ữ', 'Ư', 'Ứ', 'Ừ', 'Ự', 'Ử', 'Ữ',
            'í', 'ì', 'ị', 'ỉ', 'ĩ', 'Í', 'Ì', 'Ị', 'Ỉ', 'Ĩ',
            'ý', 'ỳ', 'ỵ', 'ỷ', 'ỹ', 'Ý', 'Ỳ', 'Ỵ', 'Ỷ', 'Ỹ'
        );
        $strReplace = array(
            '_', '_',
            'd', 'd',
            'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
            'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
            'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
            'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
            'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i',
            'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y'
        );

        return strtolower(str_replace($strFind, $strReplace, $title));
	}
        
    function getStringCut($string)
    {
        $string = $this->convertToKeyword($string);
        $string = preg_replace('/[`|~|!|@|#|%|^|&|*|(|)|-|=|\[|\]|{|}|\'|"|;|.|?|\/|>||<|,|\\|\||“]+/i', '',$string);
        $string = preg_replace('/[| |]+/i', '_',$string);
        return $string;
    }
    
	function getListPaging($cPage, $pCount)
	{
		$listPaging = array(0,0,0,0,0);
		$startShowPage = 0;
		$startShowPage = ($pCount > 5) ? (($cPage > 3) ? $cPage - 2 : 1) : 1;
		if(($cPage + 2) > $pCount && $pCount > 5 )
		{
			$startShowPage -= ($cPage + 2) - $pCount;
		}
		$index = 0;
		$i=0;
		for($i=0; $i<5; $i++)
		{
			if(($startShowPage + $i) <= $pCount)
			{
				$listPaging[$index] = $startShowPage + $i;
				$index++;
			}
			else
			{
				break;
			}
		}
		return  $listPaging;
	}
	function validEmail($email){
		if(preg_match("/[a-zA-Z0-9-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/", $email) > 0)
			return true;
		else
			return false;
	}

	function validUsername($str)
	{
	    return preg_match('/^[A-Za-z0-9_.]+$/',$str);
	}
	function _select($lstItem = array(),$catid=0,$parentid=0, $adds = '') {
		$icon = array('│','├','└');
		$select = '';
		$number=1;
		$child = $this->_child($lstItem,$parentid);
		$total = count($child);
		foreach ($lstItem as $c){
			if($c['parentid']==$parentid) {
				$j = $k = '';
				if($number == $total) {
					$j .= $icon[2];
				}else{
					$j .= $icon[1];
					$k = $adds ? $icon[0] : '';
				}
				$selected = $c['catid'] == $catid ? 'selected' : '';
				$spacer = $adds ? $adds.$j : '';
				$select .= '<option value="'.$c['catid'].'" '.$selected.'>'.$spacer.$c['catname'].'</option>';
				$select .= $this->_select($lstItem, $catid, $c['catid'], $adds.$k.'&nbsp;');
				$number++;
			}
		}
		return $select;
	}
	function _sMenu($lstItem = array(),$catid=0,$parentid=0, $adds = '') {
		$icon = array('│','├','└');
		$select = '';
		$number=1;
		$child = $this->_child($lstItem,$parentid);
		$total = count($child);
		foreach ($lstItem as $c){
			if($c['parentid']==$parentid) {
				$j = $k = '';
				if($number == $total) {
					$j .= $icon[2];
				}else{
					$j .= $icon[1];
					$k = $adds ? $icon[0] : '';
				}
				$selected = $c['menuid'] == $catid ? 'selected' : '';
				$spacer = $adds ? $adds.$j : '';
				$select .= '<option value="'.$c['menuid'].'" '.$selected.'>'.$spacer.$c['menuname'].'</option>';
				$select .= $this->_sMenu($lstItem, $catid, $c['menuid'], $adds.$k.'&nbsp;');
				$number++;
			}
		}
		return $select;
	}
	function _child($lstItem=array(),$myid) {
		$a = $newarr = array();
		if(is_array($lstItem)) {
			foreach($lstItem as $id => $a) {
				if($a['parentid'] == $myid) $newarr[$id] = $a;
			}
		}
		return $newarr ? $newarr : false;
	}
	function file_ext($filename) {
		return strtolower(trim(substr(strrchr($filename, '.'), 1)));
	}

	
	function getCookie($key){
		return isset($_COOKIE[$key]) ? trim($_COOKIE[$key]) : '';
	}
	function setCookie($key,$value='',$path='/admin/'){
		return setcookie($key, $value,time() + 60*60*24*3,$path);
	}
	
	function deditor( $textareaid = 'content', $toolbarset = 'Default', $width = 500, $height = 400) {
		$width = is_numeric($width) ? $width.'px' : $width;
		$height = is_numeric($height) ? $height.'px' : $width;
		$editor = '';
		$editor .= '<script type="text/javascript">var ModuleID = "";';
		$editor .= 'var DTAdmin = "";';
		$editor .= 'var EDPath = "'.base_url().'skin/admin/js/editor/fckeditor/";</script>';
		$editor .= '<script type="text/javascript" src="'.base_url().'skin/admin/js/editor/fckeditor/fckeditor.js"></script>';
		$editor .= '<script type="text/javascript">';
		$editor .= 'window.onload = function() {';
		$editor .= 'var sBasePath = "'.base_url().'skin/admin/js/editor/fckeditor/";';
		$editor .= 'var oFCKeditor = new FCKeditor("'.$textareaid.'");';
		$editor .= 'oFCKeditor.Width = "'.$width.'";';
		$editor .= 'oFCKeditor.Height = "'.$height.'";';
		$editor .= 'oFCKeditor.BasePath = sBasePath;';
		$editor .= 'oFCKeditor.ToolbarSet = "'.$toolbarset.'";';
		$editor .= 'oFCKeditor.ReplaceTextarea();';
		$editor .= '}';
		$editor .= '</script>';
		return $editor;
	}
	
	function font_template($name='', $temp=''){
		$dir = APPPATH.'modules/default/views';
		$_dir = scandir($dir);
		$select = '<select name="'.$name.'" id="'.$name.'">';
		foreach($_dir as $k){
			if($k != '.' && $k != '..'){
				if(is_dir($dir.'/'.$k)){
					$select .= '<option value="'.$k.'" '.($k == $temp ? ' selected' : '').'>'.$k.'</option>';
				}
			}
		}
		$select .= '</select>';
		return $select;
	}
	

	function getPage($linkUrl='',$pCount=0,$cPage=0,$lstPaging=array(),$numItem=20, $keyword='',$status=-1){
		$html = 	'<table width="100%" class="martop10">';
		$html .=	'<tr>';
		$html .=	'<td class="pad5 page">';
		$html .=	'Trang '.$cPage.' / '.$pCount.'&nbsp;&nbsp;';
		$linkUrl .= '&numItem=' . $numItem;
		if($keyword != '') {
		    $linkUrl .= '&keyword=' . $keyword;
		}
		if($status >=0){
			$linkUrl .= '&status=' . $status;
		}
		if($cPage>1){
			$page = $cPage-1;
			if($page==1)
			$html .=	'<a href="'.$linkUrl.'">Trước</a>';
			else
			$html .=	'<a href="'.$linkUrl.'&cpage='.$page.'">Trước</a>';
		}
		foreach($lstPaging as $page){
			if($page>0){
				$class='';
				if($page == $cPage)$class = 'class="curr"';
				if($page==1)
				$html .=	'<a '.$class.' href="'.$linkUrl.'">'.$page.'</a>';
				else
				$html .=	'<a '.$class.' href="'.$linkUrl.'&cpage='.$page.'">'.$page.'</a>';
			}
		}
		if($cPage<$pCount){
			$page = $cPage+1;
			$html .=	'<a href="'.$linkUrl.'&cpage='.$page.'">Sau</a>';
		}
		/*$html .=	'<select onchange="pagesize()" id="pagesize" class="pagesize">';
    	$html .=	'<option '.(($numItem == 10) ? 'selected="selected"' : '').' value="10">10</option>';
    	$html .=	'<option '.(($numItem == 20) ? 'selected="selected"' : '').' value="20">20</option>';
    	$html .=	'<option '.(($numItem == 30) ? 'selected="selected"' : '').' value="30">30</option>';
    	$html .=	'<option '.(($numItem == 40) ? 'selected="selected"' : '').' value="40">40</option>';
    	$html .=	'<option '.(($numItem == 50) ? 'selected="selected"' : '').' value="50">50</option>';
    	$html .=	'</select>';*/
		$html .=	'</td>';
		$html .=	'</tr>';
		$html .=	'</table>';
		return $html;
	}
	function xpathfile_select($name = 'xpathfile',$title = '', $xpathfile = '') {
		$template_root = APPPATH.'/xpathfile/';
		$files = glob($template_root.'*');
		$select = '<select name="'.$name.'" ><option value="">'.$title.'</option>';
		foreach($files as $tplfile)	{
			$tplfile = basename($tplfile);
			$tpl = str_replace('.php', '', $tplfile);
			if($tpl != 'these.name') {//$file == $tpl ||
				$selected = ($xpathfile && $tpl == $xpathfile) ? 'selected' : '';
				$templatename = (isset($names[$tpl]) && $names[$tpl]) ? $names[$tpl] : $tpl;
				$select .= '<option value="'.$tpl.'" '.$selected.'>'.$templatename.'</option>';
			}
		}
		$select .= '</select>';
		return $select;
	}
	function folderSize($path) {
		$total_size = 0;
		$files = scandir($path);
		$cleanPath = rtrim($path, '/'). '/';
		foreach($files as $t) {
			if ($t<>"." && $t<>"..") {
				$currentFile = $cleanPath . $t;
				if (is_dir($currentFile)) {
					$size = $this->foldersize($currentFile);
					$total_size += $size;
				}
				else {
					$size = filesize($currentFile);
					$total_size += $size;
				}
			}
		}
		return $total_size;
	}
	function createDateRangeArray($strDateFrom,$strDateTo)
    {
        $aryRange=array();
        $iDateFrom=mktime(0,0,0,substr($strDateFrom,5,2),substr($strDateFrom,8,2),substr($strDateFrom,0,4));
        $iDateTo=mktime(0,0,0,substr($strDateTo,5,2),substr($strDateTo,8,2),substr($strDateTo,0,4));
        if ($iDateTo>=$iDateFrom)
        {
                array_push($aryRange,date('Y-m-d', $iDateFrom));
                while ($iDateFrom<$iDateTo)
                {
                    $iDateFrom+=86400;
                    array_push($aryRange,date('Y-m-d',$iDateFrom));
                }
        }
        return $aryRange;
    }
}
function checkAuthGroup($group_id="1002"){
	if($group_id == "1000" && $this->session->userdata('uid')){
		return true;
	}else if($group_id == "1001" && $this->session->userdata('uid')){
		return true;
	}else if($group_id == "1002" && $this->session->userdata('uid')){
		return true;
	}else{
		return false;
	}
}
function paserDomain($url) {
	$p = parse_url ($url) ;
	if(isset($p['host'])) {
		$url = $p['host'];
	}
    	$url = str_replace('www.', '', $url);
    	if (preg_match('/^((.+)\.)?([A-Za-z][0-9A-Za-z\-]{1,63})\.([A-Za-z]{3})(\/.*)?$/',$url,$matches)) {
    		return $matches[3].'.'.$matches[4];
    	}else{
    		if (preg_match('/^((.+)\.)?([A-Za-z][0-9A-Za-z\-]{1,63})\.([A-Za-z]{3})\.([A-Za-z]{2})(\/.*)?$/',$url,$matches)) {
				$domain = array('com','pro','net','biz','gov','org','edu','int');
				if(in_array($matches[4],$domain))
					return $matches[3].'.'.$matches[4].'.'.$matches[5];
				else
					return $matches[4].'.'.$matches[5];
    		} else if (preg_match('/^((.+)\.)?([A-Za-z][0-9A-Za-z\-]{1,63})\.([A-Za-z]{2})\.([A-Za-z]{2})(\/.*)?$/',$url,$matches)) {
    			return $matches[3].'.'.$matches[4].'.'.$matches[5];
    		}else if (preg_match('/^((.+)\.)?([A-Za-z][0-9A-Za-z\-]{1,63})\.([A-Za-z]{2})(\/.*)?$/',$url,$matches)) {
    			return $matches[3].'.'.$matches[4];
    		}else{
    			return '';
    		}
    	}
}

function sendMail($mail, $subject, $message,$cc_email=''){
	require_once($_SERVER['DOCUMENT_ROOT']."/application/libraries/sendmail.php");
		$emailConfig = array();
		$emailConfig['mailtype'] = 'html';
		$config = array();
		$config['email_from'] = 'thamhut@gmail.com';
		$config['email_from_name'] = 'Rao vặt';
		$email = new CI_Email($emailConfig);
		$email->clear();
		$email->from($config['email_from'], $config['email_from_name']);					
		$email->to($mail);
		if($cc_email!=''){
			$email->cc(trim($cc_email));
		}
		$email->subject($subject);
		$body = '';
		$body .= '
        <table style="background-color:#6ACD65; background-image: url(http://chotam.info/skin/default/img/imgtopbg.gif); background-position: left top; background-repeat: repeat-x;" width="700" cellpadding="0" cellspacing="0" border="0">
        		<tr>
        			<td style="vertical-align:top;height: 70px; width:178px; overflow:hidden; border:0; padding:0; margin:0;">
        				<a href="http://chotam.info/" target="_blank" style="outline:none; padding:0; margin:0;">	
        					<img src="http://chotam.info/skin/default/img/banner_mail2.png" style="margin:0; padding:0; border:0; outline:none; width: 178px; height: 70px; display:block;" />
        				</a>
        			</td>
        			<td style="vertical-align:top; border:0; margin:0; padding:0; width: 522px; overflow:hidden;">
        				<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 5px; margin:0; line-height:1; color: #ffffff;">&nbsp;	
        				</p>
        				<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin:0; line-height:1.3; color: #ffffff;">
        					
        				</p>
        				<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin:0; line-height:1.3; color: #ffffff;">
        					<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
        				</p>
        				<table width="522" cellpadding="0" cellspacing="0" border="0">
        					<tr>
        						<td style="vertical-align:top; padding:0; margin:0; border:0; width: 460px;">
        							<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin:0; line-height:1.3; color: #ffffff;">
        								<b>Điện thoại:</b> 01667589124
        							</p>
        							<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin:0; line-height:1.3; color: #ffffff;">
        								<b>Email:</b> <a style="text-decoration: none !important; color: #fff !important;" href="mailto:thamhut@gmail.com"><span style="color: #ffffff !important;">thamhut@gmail.com</span></a>
        							</p>
        						</td>
        						<td style="vertical-align:top; padding:0; margin:0; border:0;">
        							<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 8px; margin:0; line-height:1.3; color: #ffffff;">&nbsp;</p>
        							
        						</td>
        					</tr>
        				</table>
        			</td>
        		</tr>
        	</table>
        	<table style="background-color:#fff; margin:0; padding:0;" width="700" cellpadding="0" cellspacing="0" border="0">
        	<tr>
        		<td style="vertical-align:top; border:0; margin:0; padding:0; width: 7px; overflow:hidden;">
        			<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 3px; margin:0; line-height:1.5; color: #ffffff; overflow:hidden;">&nbsp;</p>
        		</td>
        		<td style="vertical-align:top; border:0; margin:0; padding:0; width: 5px; overflow:hidden; background-color:#ececec; background-image:url(http://chotam.info/skin/default/imgleftbg.gif); background-position: left top; background-repeat: repeat-y;">
        			<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 1px; margin:0; line-height:1.5; color: #fcb220; overflow:hidden; height: 27px; width: 5px; background-color:#6ACD65;">&nbsp;</p>
        		</td>
        		<td style="vertical-align: top; width: 683px; overflow:hidden; border:0; margin:0; padding:0;">
        			<div style="padding-left: 20px; padding-right: 20px; padding-top: 20px; padding-bottom:0; margin:0; text-align: left; width: 643px; overflow:hidden;">
        				'.$message.'
        			</div>
        		</td>
        		<td style="vertical-align:top; border:0; margin:0; padding:0; width: 5px; overflow:hidden; background-color:#ececec; background-image:url(http://chotam.info/skin/default/imgrightbg.gif); background-position: left top; background-repeat: repeat-y;">
        			<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 1px; margin:0; line-height:1.5; color: #fcb220; overflow:hidden; height: 27px; width: 5px; background-color:#6ACD65;">&nbsp;</p>
        		</td>
        	</tr>
        </table>
        <table style="background-color:#fff; margin:0; padding:0;" width="700" cellpadding="0" cellspacing="0" border="0">
        	<tr>
        		<td style="vertical-align:top; border:0; margin:0; padding:0; width: 7px; overflow:hidden;">
        			<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 3px; margin:0; line-height:1.5; color: #ffffff; overflow:hidden">&nbsp;</p>
        		</td>
        		<td style="vertical-align:top; border:0; margin:0; padding:0; width: 5px; overflow:hidden; background-color:#d6d6d6;">
        			<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 1px; margin:0; line-height:1.5; color: #d6d6d6; overflow:hidden; height: 16px; width: 5px; background-color:#d6d6d6;">&nbsp;</p>
        		</td>
        		<td style="vertical-align: top; width: 683px; overflow:hidden; border:0; margin:0; padding:0;">&nbsp;
        			
        		</td>
        		<td style="vertical-align:top; border:0; margin:0; padding:0; width: 5px; overflow:hidden; background-color:#d6d6d6;">
        			<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 1px; margin:0; line-height:1.5; color: #d6d6d6; overflow:hidden; height: 16px; width: 5px; background-color:#d6d6d6;">&nbsp;</p>
        		</td>
        	</tr>
        	<tr>
        		<td style="vertical-align:top; border:0; margin:0; padding:0; width: 7px; overflow:hidden; height: 30px;">
        			<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 3px; margin:0; line-height:1.5; color: #ffffff; overflow:hidden">&nbsp;</p>
        		</td>
        		<td style="vertical-align:top; border:0; margin:0; padding:0; width: 5px; overflow:hidden; background-color:#d6d6d6;height: 30px;">
        			<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 1px; margin:0; line-height:1.5; color: #d6d6d6; overflow:hidden; height: 30px; width: 5px; background-color:#d6d6d6;">&nbsp;</p>
        		</td>
        		<td style="vertical-align: top; width: 683px; overflow:hidden; border:0; margin:0; padding:0;height: 30px;background-color:#d6d6d6; text-align:right;">
        			<a href="" target="_blank" style="outline:none; padding:0; margin:0; display:block;">	
        				<img src="http://chotam.info/skin/default/img/banner_mail_footer.png" style="margin:0; padding:0; border:0; outline:none;"/>
        			</a>
        		</td>
        		<td style="vertical-align:top; border:0; margin:0; padding:0; width: 5px; overflow:hidden; background-color:#d6d6d6;height:30px;">
        			<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 1px; margin:0; line-height:1.5; color: #d6d6d6; overflow:hidden; height: 30px; width: 5px; background-color:#d6d6d6;">&nbsp;</p>
        		</td>
        	</tr>
        </table>';
		$email->message($body);
		$email->send();
		$email->clear();
}
function sendMailSYS($mail, $subject, $message,$cc_email='', $publisher=0){
	require_once($_SERVER['DOCUMENT_ROOT']."/application/libraries/sendmail.php");
		$emailConfig = array();
		$emailConfig['mailtype'] = 'html';
		$config = array();
		$config['email_from'] = 'noreply@adclick.vn';
		$config['email_from_name'] = 'AdMicro';
		$email = new CI_Email($emailConfig);
		$email->clear();
		$email->from($config['email_from'], $config['email_from_name']);					
		$email->to($mail);
		if($cc_email!=''){
			$email->cc(trim($cc_email));
		}
		$email->subject($subject);
		$body = '';
		$body .= '
	<table style="background-color:#ffbf40; background-image: url(http://admarket.admicro.vn/images/email/v3/vietnam/topbg.gif); background-position: left top; background-repeat: repeat-x;" width="700" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td style="vertical-align:top;height: 70px; width:178px; overflow:hidden; border:0; padding:0; margin:0;">
				<a href="http://admarket.admicro.vn" target="_blank" style="outline:none; padding:0; margin:0;">	
					<img alt="" src="http://publisher.admicro.vn/skin/default/images/admicro.png" style="margin:0; padding:0; border:0; outline:none; width: 178px; height: 70px; display:block;"/>
				</a>
			</td>
			<td style="vertical-align:top; border:0; margin:0; padding:0; width: 522px; overflow:hidden;">
				<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 5px; margin:0; line-height:1; color: #ffffff;">&nbsp;	
				</p>
				<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin:0; line-height:1.3; color: #ffffff;">
					<b>Địa chỉ:</b> Tầng 16 - VTC Online Building - 18 Tam Trinh - Minh Khai - Hai Bà Trưng - Hà Nội
				</p>
				<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin:0; line-height:1.3; color: #ffffff;">
					<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> Tầng 5 tòa nhà CDC 25-27 Lê Đại Hành, Hai Bà Trưng, Hà Nội
				</p>
				<table width="522" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td style="vertical-align:top; padding:0; margin:0; border:0; width: 460px;">
							<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin:0; line-height:1.3; color: #ffffff;">
								<b>Điện thoại:</b> (04) 3 974 3959 / (04)3 974 9300 (ext: 6689)   |   Fax: (04) 3 974 3413
							</p>
							<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin:0; line-height:1.3; color: #ffffff;">
								<b>Email:</b> <a style="text-decoration: none !important; color: #fff !important;" href="mailto:inventory.adtech@vccorp.vn"><span style="color: #ffffff !important;">inventory.adtech@vccorp.vn</span></a>
							</p>
						</td>
						<td style="vertical-align:top; padding:0; margin:0; border:0;">
							<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 8px; margin:0; line-height:1.3; color: #ffffff;">&nbsp;</p>
							<a href="http://www.facebook.com/quangcao.admarket" target="_blank" style="outline:none; padding:0; margin:0; text-decoration:none;">
								<img alt="" src="http://admarket.admicro.vn/images/email/v3/vietnam/facebook.gif" style="margin:0; padding:0; border:0; outline:none; height:19px; width:24px;"/>
							</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table style="background-color:#fff; margin:0; padding:0;" width="700" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td style="vertical-align:top; border:0; margin:0; padding:0; width: 7px; overflow:hidden;">
			<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 3px; margin:0; line-height:1.5; color: #ffffff; overflow:hidden;">&nbsp;</p>
		</td>
		<td style="vertical-align:top; border:0; margin:0; padding:0; width: 5px; overflow:hidden; background-color:#ececec; background-image:url(http://admarket.admicro.vn/images/email/v3/vietnam/leftbg.gif); background-position: left top; background-repeat: repeat-y;">
			<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 1px; margin:0; line-height:1.5; color: #fcb220; overflow:hidden; height: 27px; width: 5px; background-color:#fcb220;">&nbsp;</p>
		</td>
		<td style="vertical-align: top; width: 683px; overflow:hidden; border:0; margin:0; padding:0;">
			<div style="padding-left: 20px; padding-right: 20px; padding-top: 20px; padding-bottom:0; margin:0; text-align: left; width: 643px; overflow:hidden;">';
			if($publisher==0)
            {	
                $body .= '<p style="padding:0;margin:0; text-align:left; font-family:\'Times New Roman\', Times, serif; font-size: 14px; margin:0; line-height:1.8; color: #333333;">
					Dear <strong>All</strong>,
				</p>';
            }
		//content
		$body .= '
				<p style="padding:0;margin:0; text-align:left; font-family:\'Times New Roman\', Times, serif; font-size: 14px; margin:0; line-height:1.8; color: #333333;">
					'.$message.'
				</p>';
			
		$body .= '		
				<p style="padding:0;margin:0; text-align:left; font-family:\'Times New Roman\', Times, serif; font-size: 4px; margin:0; line-height:1.8; color: #333333;">&nbsp;</p>
				<p style="padding:0;margin:0; text-align:left; font-family:\'Times New Roman\', Times, serif; font-size: 14px; margin:0; line-height:1.8; color: #333333; font-style:italic;">
					 Hệ thống Admarket sẽ giúp bạn tối đa hóa doanh thu một cách hiệu quả nhất.
				</p>
				<p style="padding:0;margin:0; text-align:left; font-family:\'Times New Roman\', Times, serif; font-size: 4px; margin:0; line-height:1.8; color: #333333;">&nbsp;</p>
				<table width="643" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td style="vertical-align:top; border:0; margin:0; padding:0; width: 558px; overflow:hidden;">
							<p style="padding:0;margin:0; text-align:left; font-family:\'Times New Roman\', Times, serif; font-size: 14px; margin:0; line-height:1.8; color: #111111; font-weight:bold;">
								Trân trọng!
							</p>
						</td>
						<td style="vertical-align:top; border:0; margin:0; padding:0; width: 85px; overflow:hidden;">
							<a href="http://publisher.admicro.vn/login/" target="_blank" style="outline:none; padding:0; margin:0; text-decoration:none; display:block;">
								<img alt="" src="http://admarket.admicro.vn/images/email/v3/vietnam/dang_nhap.gif" style="margin:0; padding:0; border:0; outline:none; height:34px; width:85px;"/>
							</a>
						</td>
					</tr>
				</table>
			</div>
		</td>
		<td style="vertical-align:top; border:0; margin:0; padding:0; width: 5px; overflow:hidden; background-color:#ececec; background-image:url(http://admarket.admicro.vn/images/email/v3/vietnam/rightbg.gif); background-position: left top; background-repeat: repeat-y;">
			<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 1px; margin:0; line-height:1.5; color: #fcb220; overflow:hidden; height: 27px; width: 5px; background-color:#fcb220;">&nbsp;</p>
		</td>
	</tr>
</table>
<table style="background-color:#fff; margin:0; padding:0;" width="700" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td style="vertical-align:top; border:0; margin:0; padding:0; width: 7px; overflow:hidden;">
			<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 3px; margin:0; line-height:1.5; color: #ffffff; overflow:hidden">&nbsp;</p>
		</td>
		<td style="vertical-align:top; border:0; margin:0; padding:0; width: 5px; overflow:hidden; background-color:#d6d6d6;">
			<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 1px; margin:0; line-height:1.5; color: #d6d6d6; overflow:hidden; height: 16px; width: 5px; background-color:#d6d6d6;">&nbsp;</p>
		</td>
		<td style="vertical-align: top; width: 683px; overflow:hidden; border:0; margin:0; padding:0;">&nbsp;
			
		</td>
		<td style="vertical-align:top; border:0; margin:0; padding:0; width: 5px; overflow:hidden; background-color:#d6d6d6;">
			<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 1px; margin:0; line-height:1.5; color: #d6d6d6; overflow:hidden; height: 16px; width: 5px; background-color:#d6d6d6;">&nbsp;</p>
		</td>
	</tr>
	<tr>
		<td style="vertical-align:top; border:0; margin:0; padding:0; width: 7px; overflow:hidden; height: 30px;">
			<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 3px; margin:0; line-height:1.5; color: #ffffff; overflow:hidden">&nbsp;</p>
		</td>
		<td style="vertical-align:top; border:0; margin:0; padding:0; width: 5px; overflow:hidden; background-color:#d6d6d6;height: 30px;">
			<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 1px; margin:0; line-height:1.5; color: #d6d6d6; overflow:hidden; height: 30px; width: 5px; background-color:#d6d6d6;">&nbsp;</p>
		</td>
		<td style="vertical-align: top; width: 683px; overflow:hidden; border:0; margin:0; padding:0;height: 30px;background-color:#d6d6d6; text-align:right;">
			<a href="http://admicro.vn" target="_blank" style="outline:none; padding:0; margin:0; display:block;">	
				<img alt="" src="http://admarket.admicro.vn/images/email/v3/vietnam/mot_san_pham_cua_admicro.gif" style="margin:0; padding:0; border:0; outline:none; width: 179px; height: 30px; overflow:hidden;"/>
			</a>
		</td>
		<td style="vertical-align:top; border:0; margin:0; padding:0; width: 5px; overflow:hidden; background-color:#d6d6d6;height:30px;">
			<p style="padding:0;margin:0; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 1px; margin:0; line-height:1.5; color: #d6d6d6; overflow:hidden; height: 30px; width: 5px; background-color:#d6d6d6;">&nbsp;</p>
		</td>
	</tr>
</table>';

		$email->message($body);
		$email->send();
		$email->clear();
}

function mydebug($params, $die=true){
    $CI = &get_instance();
    return $CI->mydebug->dump($params);
}
function viewDate($time, $type=1){
	$time = strtotime($time);
	if($type==1){
		$a = now() - $time;
		if($a < (24*60*60)){
			return timespan($time, now()).' trước';
		}else{
			return mdate('%d tháng %m lúc %h:%i', $time);
		}
	}elseif($type==2){
		return mdate('Tháng %m - %Y', $time);
	}else{
		return mdate('01 tháng %m',$time).' đến '.mdate('%d tháng %m', $time);
	}
}

function getSaveSqlStr($str) {
    if(get_magic_quotes_gpc())
    {
        return $str;
    }
    else
    {
        //return mysql_real_escape_string($str);
        $CI = &get_instance();
        return mysqli_real_escape_string($CI->db->conn_id, $str);
    }
}

function myEscapeStr($str) {
    //$str = htmlspecialchars_decode(html_entity_decode(trim($str), ENT_QUOTES, "UTF-8"), ENT_QUOTES);
    $str = trim(strip_html_tags($str));

    if(strrpos($str, "'") !== false)
    {
        $str = addslashes($str);
    }
    return $this->getSaveSqlStr($str);
}

function strip_html_tags( $text ) {
    $text =	rawurldecode($text);
    $text = htmlspecialchars_decode(html_entity_decode($text, ENT_QUOTES, "UTF-8"), ENT_QUOTES);
    $text = trim($text);
    // PHP's strip_tags() function will remove tags, but it
    // doesn't remove scripts, styles, and other unwanted
    // invisible text between tags.  Also, as a prelude to
    // tokenizing the text, we need to insure that when
    // block-level tags (such as <p> or <div>) are removed,
    // neighboring words aren't joined.
    $text = preg_replace(
            array(
                    // Remove invisible content
                    '@<head[^>]*?>.*?</head>@siu',
                    '@<style[^>]*?>.*?</style>@siu',
                    '@<script[^>]*?.*?</script>@siu',
                    '@<object[^>]*?.*?</object>@siu',
                    '@<embed[^>]*?.*?</embed>@siu',
                    '@<applet[^>]*?.*?</applet>@siu',
                    '@<noframes[^>]*?.*?</noframes>@siu',
                    '@<noscript[^>]*?.*?</noscript>@siu',
                    '@<noembed[^>]*?.*?</noembed>@siu',

                    // Add line breaks before & after blocks
                    '@<((br)|(hr))@iu',
                    '@</?((address)|(blockquote)|(center)|(del))@iu',
                    '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
                    '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
                    '@</?((table)|(th)|(td)|(caption))@iu',
                    '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
                    '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
                    '@</?((frameset)|(frame)|(iframe))@iu',
            ),
            array(
                    ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
                    "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
                    "\n\$0", "\n\$0",
            ),
            $text );

    // Remove all remaining tags and comments and return.
    return strip_tags( $text );
}
function _setCache($key,$value,$times=0){
	$time = 5*60*60;
	if (class_exists('Memcache')) {
		$memcache = new Memcache();
		$memcache->connect("192.168.4.75", 11211); 
		//$memcache->set($key, $value,false,$time);
		$memcache->set($key, array($value, time(), $time), 0, $time);
		return;
	}else{
		$CI = & get_instance();
		$CI->load->helper('file');
		$cache_dir = CACHEPATH.'output/';
		$key = sha1($key);
		$time = $times ? (60*60*$times) : (60*60*24);
		$value = array(
				'time'		=> time(),
				'ttl'		=> $time,			
				'data'		=> $value
			);
		$value = serialize($value);
		if (write_file($cache_dir.$key, $value)){
		      @chmod($cache_dir.$key, 0777);
			return TRUE;			
		}
	}
	return false;
}
function _getCache($key){
	if (class_exists('Memcache')) {
		$memcache = new Memcache();
		$memcache->connect("192.168.4.75", 11211); 
		$data = $memcache->get($key);
		if(is_array($data) && ($data[1]+$data[2])<time())return FALSE;
		else
		return (is_array($data)) ? $data[0] : FALSE;
	}else{
		$CI = & get_instance();
		$CI->load->helper('file');
		$cache_dir = CACHEPATH.'output/';
		$key = sha1($key);
      if (!file_exists($cache_dir.$key)){
			return FALSE;
		}
		$data = read_file($cache_dir.$key);
		$data = unserialize($data);
		if (time() >  $data['time'] + $data['ttl']){
			@unlink($cache_dir.$key);
			return FALSE;
		}
		return $data['data'];
	}
}
function _clearCache(){
	if (class_exists('Memcache')) {
			$memcache = new Memcache();
			$memcache->connect("192.168.4.75", 11211); 
			$memcache->flush();
	}else{
		$CI = & get_instance();
		$CI->load->helper('file');
		$cache_dir = CACHEPATH.'output/';
		return delete_files($cache_dir);
	}
}
function getPageTwo($linkUrl='',$pCount=0,$cPage=0,$lstPaging=array()){
		$html = 	'<table width="100%" class="martop10">';
		$html .=	'<tr>';
		$html .=	'<td class="pad5 page">';

		if($cPage>1){
			$page = $cPage-1;
			if($page==1)
			$html .=	'<a href="'.$linkUrl.'">Trước</a>';
			else
			$html .=	'<a href="'.$linkUrl.'?page='.$page.'">Trước</a>';
		}
		foreach($lstPaging as $page){
			if($page>0){
				$class='';
				if($page == $cPage)$class = 'class="curr"';
				if($page==1)
				$html .=	'<a '.$class.' href="'.$linkUrl.'">'.$page.'</a>';
				else
				$html .=	'<a '.$class.' href="'.$linkUrl.'?page='.$page.'">'.$page.'</a>';
			}
		}
		if($cPage<$pCount){
			$page = $cPage+1;
			$html .=	'<a href="'.$linkUrl.'?page='.$page.'">Sau</a>';
		}
		$html .=	'</td>';
		$html .=	'</tr>';
		$html .=	'</table>';
		return $html;
	}

    
    function getCacheUser($value=''){
    	$CI = & get_instance();
    	$data = $CI->session->userdata($value);
    	return $data;
    }
    function setCacheUser($key,$data){
    	$CI = & get_instance();
        $CI->session->unset_userdata($key);
    	$CI->session->set_userdata($key, $data);
    }
    
    function unsetCacheUser($key)
    {
        $CI = & get_instance();
        $CI->session->unset_userdata($key);
    }
    
    function getCurrentPageURL() {
        $pageURL = 'http';
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }
    
    function getcode()
    {
        $arr = array('a','b','c','d','e','f', 'g', 'h', 'i', 'j', 'k', 'l','n','m','o','p','q','r', 's', 't', 'u', 'v', 'w','x', 'y', 'z');
        $data = array();
        $des = array();
        $date = date('Y-m-d H:m:s').getRealIPAddress();
        $dir = 'skin/default/xacnhancp/'.getRealIPAddress();
        if (!@is_dir($dir)){
            if( ! @mkdir($dir, DIR_WRITE_MODE)){
            @chmod($dir, DIR_WRITE_MODE);
            }
        }
        for($i=0; $i<6; ++$i)
        {
            $key[] = rand(0,25);
            $source[] = $arr[$key[$i]];
            $des[] = md5($arr[$key[$i]].$date);
            copy('skin/default/xacnhan/'.$arr[$key[$i]].'.png',$dir.'/'.$des[$i].'.png');
        }
        
        $data['key'] = $source;
        $data['value'] = $des;
        return $data;
    }
    
    function deletecode($item)
    {
        if (!is_dir('skin/default/xacnhancp')) {
    
        }
        else
        {
            foreach (scandir('skin/default/xacnhancp/') as $folder) {
                if (is_dir('skin/default/xacnhancp/'.$folder) && date("d m Y H i", filectime('skin/default/xacnhancp/'.$folder))!= date("d m Y H i")) {
                    if ($folder == '.' || $folder == '..') continue;
                    foreach (scandir('skin/default/xacnhancp/'.$folder) as $item) {
                        if ($item == '.' || $item == '..') continue;
                        if (file_exists('skin/default/xacnhancp/'.$folder.'/'.$item)) {
                                unlink('skin/default/xacnhancp/'.$folder.'/'.$item);
                        }
                    }
                    rmdir('skin/default/xacnhancp/'.$folder);
                }
            }
            
        }
    }
    
    
    function getRealIPAddress(){  
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    
    function getCity($city)
    {
        $ms='';
        switch(trim($city))
        {
            case 0: $ms='Toàn quốc'; break;
            case 11: $ms='Cao Bằng'; break;
            case 12: $ms='Lạng Sơn'; break;
            case 13: $ms='Hà Bắc'; break;
            case 14: $ms='Quảng Ninh'; break;
            case 16: $ms='Hải Phòng'; break;
            case 17: $ms='Thái Bình'; break;
            case 18: $ms='Nam Định'; break;
            case 19: $ms='Phú Thọ'; break;
            case 20: $ms='Thái Nguyên'; break;
            case 21: $ms='Yên Bái'; break;
            case 22: $ms='Tuyên Quang'; break;
            case 23: $ms='Hà Giang'; break;
            case 24: $ms='Lào Cai'; break;
            case 25: $ms='Lai Châu'; break;
            case 26: $ms='Sơn La'; break;
            case 27: $ms='Điện Biên'; break;
            case 28: $ms='Hòa Bình'; break;
            case 30: $ms='Hà Nội'; break;
            case 33: $ms='Hà Tây'; break;
            case 34: $ms='Hải Dương'; break;
            case 35: $ms='Ninh Bình'; break;
            case 36: $ms='Thanh Hóa'; break;
            case 37: $ms='Nghệ An'; break;
            case 38: $ms='Hà Tĩnh'; break;
            case 43: $ms='Đà Nẵng'; break;
            case 47: $ms='Đắc Lắc'; break;
            case 49: $ms='Lâm Đồng'; break;
            case 55: $ms='TP HCM'; break;
            case 60: $ms='Đồng Nai'; break;
            case 61: $ms='Bình Dương'; break;
            case 62: $ms='Long An'; break;
            case 63: $ms='Tiền Giang'; break;
            case 64: $ms='Vĩnh Long'; break;
            case 65: $ms='Cần Thơ'; break;
            case 66: $ms='Đồng Tháp'; break;
            case 67: $ms='An Giang'; break;
            case 68: $ms='Kiên Giang'; break;
            case 69: $ms='Cà Mau'; break;
            case 70: $ms='Tây Ninh'; break;
            case 71: $ms='Bến Tre'; break;
            case 72: $ms='Vũng Tàu'; break;
            case 73: $ms='Quảng Bình'; break;
            case 74: $ms='Quảng Trị'; break;
            case 75: $ms='Huế'; break;
            case 76: $ms='Quảng Ngãi'; break;
            case 77: $ms='Bình Định'; break;
            case 78: $ms='Phú Yên'; break;
            case 79: $ms='Khánh Hòa'; break;
            case 81: $ms='Gia Lai'; break;
            case 82: $ms='Kon Tum'; break;
            case 83: $ms='Sóc Trăng'; break;
            case 84: $ms='Trà Vinh'; break;
            case 85: $ms='Ninh Thuận'; break;
            case 86: $ms='Bình Thuận'; break;
            case 88: $ms='Vĩnh Phúc'; break;
            case 89: $ms='Hưng Yên'; break;
            case 92: $ms='Quảng Nam'; break;
            case 93: $ms='Bình Phước'; break;
            case 94: $ms='Bạc Liêu'; break;
            case 97: $ms='Bắc Kạn'; break;
            case 98: $ms='Bắc Giang'; break;
            case 99: $ms='Bắc Ninh'; break;
        }
        return $ms;
    }
    
    function enhtml($s)
    {
        $s = str_replace('<','&lt;',$s);
        $s = str_replace('>','&gt;',$s);
        return $s;
    }
    
?>
