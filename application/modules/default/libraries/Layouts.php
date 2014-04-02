<?php
if( ! defined( 'BASEPATH' ))
    exit( 'No direct script access allowed' );
/**
 *
 * @author Hong Nguyen Nam <hongnguyennam@admicro.vn><namhong1983@gmail.com>
 * @copyright 2012
 */
class Layouts {
    private $_CI;
    public $_lang;
    public $_cLang;
    public $_module = array();
    public $_template;

    private $_data = array();

    function __construct() {
        $this->_CI = & get_instance();
        $this->_CI->load->model( 'common_model' );
        $this->_template = (isset( $this->_module ['template'] )) ? $this->_module ['template'] : 'default';
		
    }

    public function _loadHeader($title = '', $breadCrumb = '', $meta_title='', $meta_content='') {
        $this->_data = $this->_data;
        $this->_data ['title'] = $title;
        $this->_data ['meta_title'] = $meta_title;
        $this->_data ['meta_content'] = $meta_content;
        $this->_CI->minifier->setTemplate( $this->_template );
        //$this->addCssJs();
        
        $this->_CI->load->view( '/' . $this->_template . '/header_home_view', $this->_data);
    }

    public function _loadMenuBar() {
        $this->_data ['segment'] = $this->_CI->uri->rsegment( 1 );
        $this->_data ['username'] = '';
        $this->_data ['userid'] = '';
        
        $this->_CI->load->view( '/' . $this->_template . '/menu_view', $this->_data );
    }

    public function _loadFooter() {
        $this->_CI->load->view( '/' . $this->_template . '/footer_home_view', $this->_data );
    }

    private function addCssJs() {
        $this->_CI->minifier->AddCss( 'style_home' );
        $this->_CI->minifier->AddJsNoPack('jquery-1.8.2.min');
    }

    public function view($viewFile, $data = array()) {
        $title =(isset( $data['headTitle'] )) ? html_entity_decode( $data['headTitle'], ENT_NOQUOTES, 'UTF-8' ) : '';
        $meta_title = (isset( $data['meta_title'] )) ? html_entity_decode( $data['meta_title'], ENT_NOQUOTES, 'UTF-8' ) : '';
        $meta_content = (isset( $data['meta_content'] )) ? html_entity_decode( $data['meta_content'], ENT_NOQUOTES, 'UTF-8' ) : '';
        
        $breadCrumb =(isset( $this->_data ['breadCrumb'] )) ? $this->_data ['breadCrumb'] : '';
        $this->_loadHeader($title, $breadCrumb,$meta_title, $meta_content);
        $this->_CI->load->view( '/' . $this->_template . '/' . $viewFile, $data);
        $this->_loadFooter();
    }
}
?>
