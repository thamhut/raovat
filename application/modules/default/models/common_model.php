<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @author Hong Nguyen Nam <hongnguyennam@admicro.vn><namhong1983@gmail.com>
 * @copyright 2012
 */
class common_model extends Mymodel
{

	function setting_info()
	{
		return $this->getCacheSetting();
	}
	
 }