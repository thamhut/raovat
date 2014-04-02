<?php

/**
 * @author Anh Nguyen <duyanhnguyen@vccorp.vn>
 * @copyright 2012
 */
class MY_Exceptions extends CI_Exceptions
{

    private $_CI;
    private $_module;

    function __construct()
    {
        parent::__construct();
        if (!class_exists('CI')) {
            require BASEPATH . 'core/Lang.php';
            require BASEPATH . 'core/Controller.php';
            require APPPATH . 'third_party/MX/Base.php';
        }
        $this->_CI = & get_instance();
        $this->_module = $this->_CI->router->fetch_module();
    }

    public function show_error($heading, $message, $template = 'error_general', $status_code = 500)
    {
        set_status_header($status_code);

        $message = '<p>' . implode('</p><p>', (!is_array($message)) ? array($message) : $message) . '</p>';
        $existsErrorPage = false;
        if (ob_get_level() > $this->ob_level + 1) {
            ob_end_flush();
        }
        ob_start();
        foreach (Modules::$locations as $location => $offset) {
            if (is_file($location . $this->_module . DIRECTORY_SEPARATOR . 'errors/' . $template . '.php')) {
                include($location . $this->_module . DIRECTORY_SEPARATOR . 'errors/' . $template . '.php');
                $existsErrorPage = true;
            }
        }
        if (!$existsErrorPage) {
            include(APPPATH . 'errors/' . $template . '.php');
        }
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }

}

?>
