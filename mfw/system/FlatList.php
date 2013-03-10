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

class FlatList {
	
	/**
	 * @var array $parameters
	 */
	protected $parameters;
	
	/**
	 * 
	 * @return void
	 */
	public function __construct() {
		$this->parameters = array();
	}
	
	/**
	 * 
	 * @param key $key
	 * @param value $value
	 */
	public function set($key, $value) {
		$this->parameters[$key] = $value;
	}
	public function __set($key, $value) {
		$this->set($key, $value);
	}
	
	/**
	 * 
	 * @param string $param
	 * @return mixed
	 * @throws Exception
	 */
	public function get($param) {
		if($this->has($param)) 
			return $this->parameters[$param];
		throw new Exception('Paramater, $param, does not exist in this collection');
	}
	public function __get($param) {
		return $this->get($param);
	}
	
	/**
	 * 
	 * @param string $param
	 * @return bool
	 */
	public function has($param) {
		return array_key_exists($param, $this->parameters);
	}
	public function __isset($param) {
		return $this->has($param);
	}
	
	/** 
	 * 
	 * @param string $param
	 */
	public function remove($param) {
		if($this->has($param))
			unset($this->parameters[$param]);
	}
	public function __unset($param) {
		$this->remove($param);
	}
	
}

}

?>