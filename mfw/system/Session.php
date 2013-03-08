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

namespace mfw\system {
	
/**
 * SessionRegister
 *
 * Singleton
 *
 * This is for read write value passing with State
 *
 * Data is all Stored in Super Global $_SESSION or $GLOBALS['_SESSION'] on CLI
 */
class Session {
	
	/**
	 * @var Session $instance
	 */
	private static $instance;
	
	/**
	 * getInstance
	 *
	 * @return SessionRegister
	 */
	public static function instance() {
		if(empty(self::$instance)) {
			self::$instance = new Session();
		}
		return self::$instance;
	}
	
	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		session_start();
	}
	
	/**
	 * setParam
	 *
	 * @param key $key
	 * @param value $value
	 * @param string $class (Optional)
	 */
	public function setForClass($key, $value, $class = __CLASS__) {
		$_SESSION[$class][$key] = $value;
	}
	public function set($key, $value) {
		if(empty($_SESSION))
			$GLOBALS['_SESSION'][$key] = $value;
		else
			$_SESSION[$key] = $value;
	}
	public function __set($key, $value) {
		if(empty($_SESSION))
			$GLOBALS['_SESSION'][$key] = $value;
		else
			$_SESSION[$key] = $value;
	}
	
	/**
	 * getParam
	 *
	 * @param string $param
	 * @param string $class (optional)
	 * @return mixed
	 */
	public function getForClass($param, $class = __CLASS__) {
		if($this->has($param)) 
			return $this->parameters[$class][$param];
		throw new Exception("Parameter '$param' does not exist.");
	}
	public function get($param) {
		if($this->has($param)) {
			if(empty($_SESSION))
				return $GLOBALS['_SESSION'][$param];
			else
				return $_SESSION[$param];
		}
		throw new Exception("$param not found in Request");
	}
	public function __get($param) {
		if($this->has($param)) {
			if(empty($_SESSION))
				return $GLOBALS['_SESSION'][$param];
			else
				return $_SESSION[$param];
		}
		throw new Exception("$param not found in Request");
	}
	
	/**
	 * hasParam
	 *
	 * @param string $param
	 * @return bool
	 */
	public function hasForClass($param, $class = __CLASS__) {
		if(is_array($_SESSION[$class]))
			return array_key_exists($param, $_SESSION[$class]);
		return false;
	}
	public function has($param) {
		if(empty($_SESSION))
			return array_key_exists($param, $GLOBALS['_SESSION']);
		else
			return array_key_exists($param, $_SESSION);
	}
	
	
	public function printDebug() {
		echo "GLOBALS\n";
		print_r($GLOBALS['_SESSION']);
		echo "\nSESSION\n";
		print_r($_SESSION);
	}
	
}

}

?>