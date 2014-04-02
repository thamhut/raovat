<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Anh Nguyen <duyanhnguyen@vccorp.vn>
 * @copyright 2012
 */

include 'minifier/CSSmin.php';
include 'minifier/JSmin.php';
include 'minifier/JSpacker.php';

class Minifier {

    protected static $files = array();
    protected static $noPackJS = array();
    protected static $_CI;
    protected static $_module;
    protected static $_template = 'default';

    function __construct()
    {
        self::$_CI =& get_instance();
        self::$_module = self::$_CI->router->fetch_module();
    }

    public function AddJsFileNoPack($files, $ext) {
        if (!$files)
            return;
        $ext = strtolower($ext);
        if ($ext == 'shared_js')
            $ext = 'js';
        $files = explode(',', $files);
        foreach ($files as $file) {
            $file = trim($file) . '.js';
            $path = SKIN . self::$_template . '/' . DIR_JS . $file;
            self::$noPackJS[$path] = $path;
        }
    }

    public static function AddFile($files, $type) {
        if (!$files)
            return;
        $files = explode(',', $files);
        $ext = strtolower($type);
        if ($ext == 'shared_js')
            $ext = 'js';
        foreach ($files as $file) {
            $file = trim($file) . ".$ext";
            if ($ext == 'js') {
                $path =  SKIN . self::$_template . '/' . DIR_JS . $file;
            } else {
                $path =  SKIN . self::$_template . '/' . DIR_CSS . $file;
            }
            self::$files[$ext][$path] = $path;
        }
    }

    public function GetCombined($ext) {
        if (JS_COMBINE_MODE) {
            $src = $this->CombineFile($ext);
            $ext = strtolower($ext);
            $return_method = "Return$ext";
            $out[] = $this->$return_method($src);
        } else if (isset(self::$files[$ext])) {
            foreach (self::$files[$ext] as $file) {
                $src = $this->RenderFile($file);
                $return_name = "Return$ext";
                $out[] = $this->$return_name($src);
            }
        }
        if ($ext == 'js') {
            foreach (self::$noPackJS as $file) {
                $out[] = self::ReturnJsNoPack($file);
            }
        }
        return implode("\n", $out);
    }

    public static function Returncss($src) {
        return "<link rel='stylesheet' type='text/css' href='" . base_url() . CACHEPATH . self::$_template . "_css/$src' />";
    }
    public static function Returnjs($src) {
        return "<script type='text/javascript' src='" . base_url() . CACHEPATH  . self::$_template . "_js/$src'></script>";
    }
    public static function ReturnJsNoPack($src) {
        return "<script type='text/javascript' src='" . base_url(). "$src'></script>";
    }
    protected function CombineFile($ext) {
        $hash = $this->GetHash(self::$files[$ext]);
        $name = "$hash.$ext";
        $path = CACHEPATH. self::$_template . '_' . $ext . '/';
        $file = $path . $name;
        if (!file_exists($file)) {
            $this->MakeDir($path);
            $value = $this->Combine($file, self::$files[$ext]);
            $pack_method = "Pack$ext";
            $value = $this->$pack_method($value);
            $this->Write($file, $value);
        }
        return $name;
    }

    protected function GetHash($files) {
        $time = null;
        foreach ($files as $file) {
            if (file_exists($file))
                $time .= filemtime($file);
        }
        return substr(md5($time), 0, 16);
    }

    protected function RenderFile($origin_file) {
        if (!file_exists($origin_file))
            return null;
        $file_name = basename($origin_file);
        $base_path = dirname($origin_file);
        $ext = $this->GetExt($origin_file);
        $hash = filemtime($origin_file);
        $name = $this->GetName($origin_file) . ".$hash.$ext";
        $path = CACHEPATH. self::$_template . '_' . $ext;
        $file = $path . '/' . $name;
//        @unlink($file);
        if (!file_exists($file)) {
            $pack_method = "Pack$ext";
            $value = $this->Read($origin_file);
            $value = $this->$pack_method($value);
            $this->MakeDir($path);
            $this->Write($file, $value);
        }
        return $name;
    }

    public function AddSharedJsNoPack($files) {
        $this->AddJsFileNoPack($files, 'SHARED_JS');
    }

    public function AddJsNoPack($files) {
        $this->AddJsFileNoPack($files, 'JS');
    }

    public function AddSharedJs($files) {
        $this->AddFile($files, 'SHARED_JS');
    }

    public function AddJs($files) {
        $this->AddFile($files, 'JS');
    }

    public function AddCss($files) {
        $this->AddFile($files, 'CSS');
    }

    public static function GetExt($file) {
        return strtolower(pathinfo($file, PATHINFO_EXTENSION));
    }

    public static function GetName($file) {
        return pathinfo($file, PATHINFO_FILENAME);
    }

    public static function MakeDir($dir, $chmod = 0777) {
        if (!file_exists($dir)) {
            mkdir($dir);
            chmod($dir, $chmod);
        }
    }

    public static function Write($file, $data, $mode = 'w') {
        $handle = fopen($file, $mode);
        fwrite($handle, $data);
        fclose($handle);
        return true;
    }

    public static function Read($file) {
        if (!file_exists($file))
            throw new Exception("File not found: $file");
        return file_get_contents($file);
    }

    public function Combine($combined_file, $files) {
        $combined = null;
        foreach ($files as $file) {
            if (file_exists($file)) {
                $tmptxt = $this->Read($file);
                $combined .= "\n" . $tmptxt;
            }
        }
        $this->Write($combined_file, $combined);
        return $combined;
    }

    public static function Packjs($js) {
        if (JS_PACK_MODE) {
            $packer = new JSpacker($js);
            return $packer->pack();
        } else if (JS_MINIFY_MODE)
            return JSmin::minify($js);
        else
            return $js;
    }

    public static function Packcss($css) {
        if (JS_PACK_MODE || JS_MINIFY_MODE) {
            $min = new CSSmin();
            return $min->minify($css);
        }
        else
            return $css;
    }
	public static function setTemplate($template='') {
        return self::$_template = $template;
    }

}
?>
