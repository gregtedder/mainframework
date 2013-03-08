<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2013 Greg Tedder
 *
 * Permission is hereby granted, free of charge, to any person obtaining a 
 * copy of this software and associated documentation files (the "Software"), 
 * to deal in the Software without restriction, including without limitation 
 * the rights to use, copy, modify, merge, publish, distribute, sublicense, 
 * and/or sell copies of the Software, and to permit persons to whom the 
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included 
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS 
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER 
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING 
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER 
 * DEALINGS IN THE SOFTWARE.
 */

namespace mfw\system
{

/**
 *
 * Contoller
 *
 * This is the application controller
 */
class Controller {
	
	/**
	 * @var path
	 */
	protected $_control_path;
	
	/**
	 * @var $parameters
	 */
	protected $_parameters;
	
	/**
	 *
	 * Set the path to the controller so the views can be found.
	 *
	 * @param __CLASS__ $class
	 * @param __FILE__ $file
	 */
	public function __construct($class, $file) {
		$class = '/controllers/' . $class . '.php';
		$chunk = explode($class, $file);
		$this->_control_path = $chunk[0];
	}
	
	/**
	 *
	 * Load the view, and optionally add varialbles.
	 *
	 * @param string $file_name
	 * @param array $parameters
	 */
	public function loadView($file_name, $parameters = null) {
		if($parameters != null && is_array($parameters)) 
			extract($parameters);
		include $this->_control_path . '/views/' . $file_name . '.php';
	}
	
	/**
	 *
	 * Load the view, into a template
	 *
	 * @param \mfw\system\Template $template
	 * @param string $file_name
	 * @param array $parameters
	 */
	public function loadViewToTemplate(\mfw\system\Template $template, $file_name, $parameters = null) {
		if($parameters != null && is_array($parameters)) 
			extract($parameters);
		ob_start();
		include $this->_control_path . '/views/' . $file_name . '.php';
		$template->body = ob_get_clean();
		$template->render();
	}
	
	// loadViewToTemplate($file_name, $tempate_name, $parameters = null)
	
}

}

?>