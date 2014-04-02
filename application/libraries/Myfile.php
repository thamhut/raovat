<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Hongnn
 */
class MyFile {	
	function fileDown($file, $filename = '') {
		if(!is_file($file)) message('', SITE_URL);
		$filename = $filename ? $filename : basename($file);
		$filetype = file_ext($filename);
		$filesize = filesize($file);
		ob_end_clean();
		@set_time_limit(0);
		header('Cache-control: max-age=31536000');
		header('Expires: '.gmdate('D, d M Y H:i:s', time() + 31536000).' GMT');
		header('Content-Encoding: none');
		header('Content-Length: '.$filesize);
		header('Content-Disposition: attachment; filename='.$filename);
		header('Content-Type: '.$filetype);
		readfile($file);
		exit;
	}

	function fileList($dir, $fs = array()) {
		$files = glob($dir.'/*');
		if(!is_array($files)) return $fs;
		foreach($files as $file) {
			if(is_dir($file)) {
				$fs = $this->fileList($file, $fs);
			} else {
				$fs[] = $file;
			}
		}
		return $fs;
	}

	function fileCopy($from, $to) {
		$this->dirCreate(dirname($to));
		if(is_file($to)) {
			if(DIR_WRITE_MODE) @chmod($to, DIR_WRITE_MODE);
		}
		if(@copy($from, $to)) {
			if(DIR_WRITE_MODE) @chmod($to, DIR_WRITE_MODE);
			return true;
		} else {
			return false;
		}
	}

	function dirPut($filename, $data) {
		$this->dirCreate(dirname($filename));
		file_put_contents($filename, $data);
		if(DIR_WRITE_MODE) @chmod($filename, DIR_WRITE_MODE);
		return is_file($filename);
	}

	function dirPath($dirpath) {
		$dirpath = str_replace('\\', '/', $dirpath);
		if(substr($dirpath, -1) != '/') $dirpath = $dirpath.'/';
		return $dirpath;
	}

	function dirCreate($path) {
		if(is_dir($path)) return true;
		$dir = str_replace(DT_ROOT.'/', '', $path);
		$dir = $this->dirPath($dir);
		$temp = explode('/', $dir);
		$cur_dir = DT_ROOT.'/';
		$max = count($temp) - 1;
		for($i = 0; $i < $max; $i++) {
			$cur_dir .= $temp[$i].'/';
			if(is_dir($cur_dir)) continue;
			@mkdir($cur_dir);
			if(DIR_WRITE_MODE) @chmod($cur_dir, DIR_WRITE_MODE);
		}
		return is_dir($path);
	}

	function dirChmod($dir, $mode = '', $require = 0) {
		if(!$require) $require = substr($dir, -1) == '*' ? 2 : 0;
		if($require) {
			if($require == 2) $dir = substr($dir, 0, -1);
			$dir = $this->dirPath($dir);
			$list = glob($dir.'*');
			foreach($list as $v) {
				if(is_dir($v)) {
					$this->dirChmod($v, $mode, 1);
				} else {
					@chmod(basename($v), $mode);
				}
			}
		}
		if(is_dir($dir)) {
			@chmod($dir, $mode);
		} else {
			@chmod(basename($dir), $mode);
		}
	}

	function dirCopy($fromdir, $todir) {
		$fromdir = $this->dirPath($fromdir);
		$todir = $this->dirPath($todir);
		if(!is_dir($fromdir)) return false;
		if(!is_dir($todir)) $this->dirCreate($todir);
		$list = glob($fromdir.'*');
		foreach($list as $v) {
			$path = $todir.basename($v);
			if(is_file($path) && !is_writable($path)) {
				if(DIR_WRITE_MODE) @chmod($path, DIR_WRITE_MODE);
			}
			if(is_dir($v)) {
				$this->dirCopy($v, $path);
			} else {
				@copy($v, $path);
				if(DIR_WRITE_MODE) @chmod($path, DIR_WRITE_MODE);
			}
		}
		return true;
	}

	function dirDelete($dir) {
		$dir = $this->dirPath($dir);
		if(!is_dir($dir)) return false;
		$systemdirs = array(DT_ROOT.'/admin/', DT_ROOT.'/uploads/');
		if(substr($dir, 0, 1) == '.' || in_array($dir, $systemdirs)) die("Cannot remove system dir $dir ");
		$list = glob($dir.'*');
		if($list) {
			foreach($list as $v) {
				is_dir($v) ? $this->dirDelete($v) : @unlink($v);
			}
		}
		return @rmdir($dir);
	}
}
?>