<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX core module class */
require dirname(__FILE__).'/Modules.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library extends the CodeIgniter router class.
 *
 * Install this file as application/third_party/MX/Router.php
 *
 * @copyright	Copyright (c) 2011 Wiredesignz
 * @version 	5.4
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Router extends CI_Router
{
	protected $module;
	
	public function fetch_module() {
		return $this->module;
	}
	
	public function _validate_request($segments) {
		if (count($segments) == 0) return $segments;
        
		/* locate module controller */
		if ($located = $this->locate($segments)) return $located;
        
		/* use a default 404_override controller */
		if (isset($this->routes['404_override']) AND $this->routes['404_override']) {
			$segments = explode('/', $this->routes['404_override']);
			if ($located = $this->locate($segments)) return $located;
		}
		
		/* no controller found */
		show_404();
	}
	
	/** Locate the controller **/
	public function locate($segments) {		
		$this->module = '';
		$this->directory = '';
		$ext = $this->config->item('controller_suffix').EXT;
        $moduleDefault = $this->config->item('modules_default');
		
		/* use module route if available */
		if (isset($segments[0]) AND $routes = Modules::parse_routes($segments[0], implode('/', $segments))) {
			$segments = $routes;
		}
		/* get the segments array elements */
		list($module, $directory, $controller) = array_pad($segments, 3, NULL);
        
		/* check modules */
		foreach (Modules::$locations as $location => $offset) {
		
			/* module exists? */
			if (is_dir($source = $location.$module.'/controllers/')) {
				$this->module = $module;
				$this->directory = $offset.$module.'/controllers/';
				/* module sub-controller exists? */
				if($directory AND is_file($source.$directory.$ext)) {
					return array_slice($segments, 1);
				}
				/* module sub-directory exists? */
				if($directory AND is_dir($source.$directory.'/')) {

					$source = $source.$directory.'/'; 
					$this->directory .= $directory.'/';
					/* module sub-directory controller exists? */
					if(is_file($source.$directory.$ext)) {
						return array_slice($segments,1);
					}
				
					/* module sub-directory sub-controller exists? */
					if($controller AND is_file($source.$controller.$ext))	{
						return array_slice($segments, 2);
					}
				}
				
				/* module controller exists? */			
				if(is_file($source.$module.$ext)) {
					return $segments;
				}
                
                
                if(is_file($source . Modules::$routes[$module]['default_controller'] . '/' . Modules::$routes[$module]['default_controller'] . $ext) && !isset($segments[1])) {
                    $this->directory = $this->directory . Modules::$routes[$module]['default_controller'] . '/';
                    return array(Modules::$routes[$module]['default_controller']);
                }
			}
            
            
            //module default
            if (is_dir($source = $location . $moduleDefault . '/controllers/')) {
                $this->directory = $offset.$moduleDefault.'/controllers/';
				/* module sub-controller exists? */
				if($module AND is_file($source.$module.$ext)) {
                    $this->module = $moduleDefault;
					return $segments;
				}
				/* module sub-directory exists? */
				if($module AND is_dir($source.$module.'/')) {
                    $this->module = $moduleDefault;
					$source = $source.$module.'/';
					$this->directory .= $module.'/';
					/* module sub-directory controller exists? */
					if(is_file($source.$module.$ext)) {
						return $segments;
					}
				}
                
                if(isset(Modules::$routes[$moduleDefault])) {
                    if(is_file($source . Modules::$routes[$moduleDefault]['default_controller'] . '/' . Modules::$routes[$moduleDefault]['default_controller'] . $ext) && !isset($segments[1])) {
                        $this->module = $moduleDefault;
                        $this->directory = $this->directory . Modules::$routes[$moduleDefault]['default_controller'] . '/';
                        return array(Modules::$routes[$moduleDefault]['default_controller']);
                    }
                }
            }
		}
        
        if($this->module == '')
            $this->module = $moduleDefault;
        
	}

	public function set_class($class) {
		$this->class = $class.$this->config->item('controller_suffix');
	}
}