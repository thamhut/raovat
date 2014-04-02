<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $_lang;
    protected $_data = array();

    public function __construct() {
        parent::__construct();
        header("Content-type: text/html; charset=utf-8");
        $this->load->library('Layout');
        $this->load->model('home/home_model');
        $this->init();
        $this->numrow = 50;
    }

    public function init() {}
}