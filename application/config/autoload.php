<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @author Hong Nguyen Nam <hongnguyennam@admicro.vn><namhong1983@gmail.com>
 * @copyright 2012
 */
$autoload['packages'] = array();
$autoload['libraries'] = array('database', 'session', 'mycommon', 'myimage', 'myfile', 'upload', 'mycache', 'minifier', 'mychart', 'Mydebug');
$autoload['helper'] = array('common', 'url', 'cookie', 'cache','date','html');
$autoload['config'] = array();
$autoload['language'] = array();
$autoload['model'] = array('Mymodel');


/* End of file autoload.php */
/* Location: ./application/config/autoload.php */