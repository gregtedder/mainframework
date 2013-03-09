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
 
namespace mfw\system{

class Router {
	
	/** 
	 * 
	 * @var string
	 */
	protected $app_directory;
	
	/** 
	 * 
	 * @var string
	 */
	protected $controller;
	
	/** 
	 * 
	 * @var string
	 */
	protected $method;
	
	/** 
	 * 
	 * @var array
	 */
	protected $arguments;
	
	/** 
	 * 
	 * @param string $app_directory
	 * @param string $sub_request_uri
	 */
	public function __construct($app_directory, $app_url) {
		if($app_url == '') {
			$controller_name = 'home';
			$method_name = 'get';
			$arguments = array();
		} else {
			$params = explode('/', $app_url);
			$controller_name = $params[0];
			if(empty($params[1])) 
				$method_name = 'get';
			else
				$method_name = $params[1];
			$arguments = array();
			if(count($params) > 2) {
				for($i = 2; $i < count($params); $i++) {
					if(trim($params[$i]) != '')
						$arguments[] = $params[$i];
				}
			}
		}
		$this->app_directory = $app_directory;
		$this->controller = $this->convertControllerName($controller_name);
		$this->method = $this->convertMethodName($method_name);
		$this->arguments = $arguments;
	}
	
	/** 
	 * 
	 * @param string $contoller_name
	 * @return string $controller
	 */
	protected function convertControllerName($controller_name) {
		$chunks = explode('_', $controller_name);
		$class = '';
		for($i = 0; $i < count($chunks); $i++) {
			$letter = strtoupper(substr($chunks[$i], 0, 1));
			$class .= $letter . substr($chunks[$i], 1);
		}
		$class .= 'Controller';
		return $class;
	}
	
	/** 
	 * 
	 * @param string $method_name
	 * @return string $method
	 */
	protected function convertMethodName($method_name) {
		$chunks = explode('_', $method_name);
		$method = ''; //
		for($i = 0; $i < count($chunks); $i++) {
			if($i > 0) {
				$letter = strtoupper(substr($chunks[$i], 0, 1));
				$method .= $letter . substr($chunks[$i], 1);
			} else {
				$method .= $chunks[$i];
			}
		}
		return $method;
	}
	
	/** 
	 * 
	 * Traverse the configured route if it exists.
	 * 
	 * @throws Exception
	 */
	public function route() {
		$file = $this->app_directory . '/controllers/' . $this->controller . '.php';
		if(\mfw\helpers\FileHelper::fileExists($file)) {
			include $this->app_directory . '/controllers/' . $this->controller . '.php';
			$controller = new $this->controller($this->controller, $this->app_directory);
			call_user_func_array(array($controller, $this->method), $this->arguments);
		} else {
			if(defined('DOC_ROOT')) {
				include DOC_ROOT . '/404.php';
			} else {
				throw new \Exception("404 Page not found");
			}
		}
	}
	
}

}

?>