<?php
class Mycache {

	public $expire_after = 300;
    public $cache_dir;
	
	function __construct()
	{
		if (empty($this->cache_dir) == true)
		{

			$this->cache_dir = CACHEPATH;			
		}
	}	
	function cache_item($key, $value){
		$CI = & get_instance();
		$key = sha1($key);
		$value = serialize($value);
		if (!@is_dir($this->cache_dir.$cache_dir))
			{
				$CI->myfile->dirCreate($this->cache_dir.''.$cache_dir);
				$CI->myfile->fileCopy($this->cache_dir.'index.html', $this->cache_dir.$cache_dir.'index.html');
				$CI->myfile->fileCopy($this->cache_dir.'index.html', $this->cache_dir.$cache_dir.'index.html');
			}
		file_put_contents($this->cache_dir.$cache_dir.$key.'.cache', $value);		
	} 
	function is_cached($key, $cache_dir='')
	{
		$key = sha1($key);        
        $file_expires = file_exists($this->cache_dir.$cache_dir.$key.'.cache');
		if ($file_expires >= time())
		{			
			return true;
		} else {
			return false;			
		}		
	}
	function get_item($key, $cache_dir='')
	{
		$key = sha1($key);
		$item = file_get_contents($this->cache_dir.$cache_dir.$key.'.cache');
		$items = unserialize($item);

		return $items;
	}
	function delete_item($key, $cache_dir='')
	{
		@unlink($this->cache_dir.$cache_dir.sha1($key).'.cache');
	}
}