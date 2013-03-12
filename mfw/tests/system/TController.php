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

require 'config.php';

class TController extends PHPUnit_Framework_TestCase {
	
	public static $controller;
	
	public function testAppDirectory() {
		return MFW_PATH . '/mfw/tests/test_app';
	}
	
	public function testController() {
		return 'TestController';
	}
	
	public function testArguments() {
		return array('an optional argument');
	}
	
	/** 
	 * 
	 * @depends testAppDirectory
	 * @depends testController
	 */
	public function testCreateController($tapp_directory, $tcontroller) {
		if(empty(self::$controller)) {
			include $tapp_directory . '/controllers/' . $tcontroller . '.php';
			self::$controller = new $tcontroller($tcontroller, $tapp_directory);
		}
		return self::$controller;
	}
	
	
	/** 
	 * 
	 * @depends testCreateController
	 * @depends testArguments
	 */
	public function testGet($controller, $targuments) {
		$tmethod = 'get';
		ob_start();
		call_user_func_array(array($controller, $tmethod), $targuments);
		$value = ob_get_clean();
		$expected = "Get Method";
		$this->assertEquals($expected, $value);
	}
	
	/** 
	 * 
	 * @depends testCreateController
	 * @depends testArguments
	 */
	public function testControllerGetView($controller, $targuments) {
		$tmethod = 'getView';
		ob_start();
		call_user_func_array(array($controller, $tmethod), $targuments);
		$value = ob_get_clean();
		$expected = 'The Test View an optional argument';
		$this->assertEquals($expected, $value);
	}
	
	/** 
	 * 
	 * @depends testCreateController
	 * @depends testArguments
	 */
	public function testControllerGetTemplateView($controller, $targuments) {
		$tmethod = 'getTemplateView';
		ob_start();
		call_user_func_array(array($controller, $tmethod), $targuments);
		$value = ob_get_clean();
		$expected = 'This is for Unit Testing Templates The Test View ' . date('Y-m-d');
		$this->assertEquals($expected, $value);
	}
	
}

?>