<?php
if( ! defined( 'BASEPATH' ))
    exit( 'No direct script access allowed' );
/**
 *
 * @author Hong Nguyen Nam <hongnguyennam@admicro.vn><namhong1983@gmail.com>
 * @copyright 2012
 */
class Layout {
    private $_CI;
    public $_lang;
    public $_cLang;
    public $_module = array();
    public $_template;

    private $_data = array();

    function __construct() {
        $this->_CI = & get_instance();
        $this->_lang = $this->_CI->mycommon->getLangCode();
        $this->_CI->load->language( 'common', $this->_lang );
        $this->_cLang = $this->_CI->lang->line( 'common_lang' );
        $this->_CI->load->model( 'common_model' );
        /*$this->_template = (isset( $this->_module ['template'] )) ? $this->_module ['template'] : 'default';
		  set_time_limit(0);
        if( ! getCacheUser('uid')) {
            if(	! ($this->_CI->uri->rsegment( 1 ) == 'login' 
            	|| $this->_CI->uri->rsegment( 1 ) == 'home' 
            	|| $this->_CI->uri->rsegment( 1 ) == 'register' 
					|| $this->_CI->uri->rsegment( 2 ) == 'inpayment'
					|| $this->_CI->uri->rsegment( 2 ) == 'inzone' || $this->_CI->uri->rsegment( 2 ) == 'intoprice' || $this->_CI->uri->rsegment( 2 ) == 'inzonelastdate'|| $this->_CI->uri->rsegment( 2 ) == 'inzonedate') ) 
            {
                redirect( base_url( 'login' ) );
                die();
            }
        } elseif($this->_CI->uri->rsegment( 1 ) == 'login') {
        	redirect( base_url( 'overview' ) );
        	die();
        }*/
    }

    public function _loadHeader($title = '', $breadCrumb = '') {
        $this->_data = $this->_data;
        $this->_data ['title'] = $title;
        $this->_data ['lang'] = $this->_lang;
        $this->_CI->minifier->setTemplate( $this->_template );
        $this->addCssJs();
        $this->_data ['combinedCss'] = $this->_CI->minifier->GetCombined( 'css' );
        $this->_data ['combinedJs'] = $this->_CI->minifier->GetCombined( 'js' );
        $this->_data ['username'] = '';
        $this->_data ['userid'] = '';
        if(getCacheUser('uname')) {
            $this->_data ['username'] = getCacheUser('uname');
            $this->_data ['userid'] = getCacheUser('uid');
        }
		  
        $this->_CI->load->view( '/' . $this->_template . '/header_view', $this->_data);
    }

    public function _loadMenuBar() {
        $this->_data ['lang'] = $this->_cLang;
        $this->_data ['segment'] = $this->_CI->uri->rsegment( 1 );
        $this->_data ['username'] = '';
        $this->_data ['userid'] = '';
        if(getCacheUser('uname')) {
            $this->_data ['username'] = getCacheUser('uname');
            $this->_data ['userid'] = getCacheUser('uid');
        }
        $this->_CI->load->view( '/' . $this->_template . '/menu_view', $this->_data );
    }

    public function _loadFooter() {
        $this->_data['lang'] = $this->_cLang;
        $this->_data['combinedJs'] = $this->_CI->minifier->GetCombined( 'js' );
        $this->_CI->load->view( '/' . $this->_template . '/footer_view', $this->_data );
    }

    private function addCssJs() {
        $this->_CI->minifier->AddCss( 'style' );
        $this->_CI->minifier->AddCss( 'tipsy' );
        $this->_CI->minifier->AddCss( 'datepicker' );
        $this->_CI->minifier->AddCss('token-input');
        $this->_CI->minifier->AddJs( 'jquery-1.4.4.min' );
        //$this->_CI->minifier->AddJsNoPack('jquery-1.8.2.min');
        $this->_CI->minifier->AddJsNoPack('jquery.tokeninput');
        $this->_CI->minifier->AddJsNoPack( 'highcharts.src' );
        $this->_CI->minifier->AddJsNoPack( 'exporting.src' );
        $this->_CI->minifier->AddJsNoPack( 'chartView' );
        $this->_CI->minifier->AddJsNoPack( 'jquery-latest' );
        $this->_CI->minifier->AddJsNoPack( 'jquery.tablesorter' );
        $this->_CI->minifier->AddJsNoPack( 'datepicker' );
        $this->_CI->minifier->AddJsNoPack( 'coin-slider.min' );
        $this->_CI->minifier->AddJsNoPack( 'common' );
        $this->_CI->minifier->AddJsNoPack( 'jquery.tipsy' );
    }

    public function view($viewFile, $data = array()) {
        $title =(isset( $data ['headTitle'] )) ? html_entity_decode( $data['headTitle'], ENT_NOQUOTES, 'UTF-8' ) : '';
        $breadCrumb =(isset( $this->_data ['breadCrumb'] )) ? $this->_data ['breadCrumb'] : '';
        
        $this->_loadHeader($title, $breadCrumb);
        $this->_loadMenuBar();
        $this->_CI->load->view( '/' . $this->_template . '/' . $viewFile, $data);
        $this->_loadFooter();
    }
}
?>
