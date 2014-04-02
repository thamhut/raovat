<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @author Tham Nguyen Van
 * @copyright 2014
 */
class Logout extends CI_Controller
{
	// constructor
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
        unsetCacheUser('user');
        redirect(base_url());
	}
}