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
 
 namespace mfw\system\log {
 
 /** 
  * 
  * This is a base class for logging messages. 
  */
 class LogMessage implements Loggable {
 	
	/** 
	 * 
	 * @var string
	 */
	private $message;
	
	/** 
	 * 
	 * @var bool
	 */
	private $trace;
	
	/** 
	 * 
	 * @var bool
	 */
	private $debug_trace;
 	
	/** 
	 * 
	 * @param string $message
	 */
	public function __construct($message, $trace = true) {
		$this->message = $message;
		$this->trace = $trace;
		$this->debug_trace = debug_backtrace();
	}
	
	/** 
	 * 
	 * @return string
	 */
	public function getMessage() {
		return $this->message;
	}
	
	/** 
	 * 
	 * @return string
	 */
	public function getTrace() {
		$debug_trace = $this->debug_trace;
		
		if($this->trace) {
			$e = new \Exception('');
			$message = $e->getTraceAsString();
		} else {
			$message = $this->catTraceRow($debug_trace[0], 0);
		}
		return $message;
	}
	
	/** 
	 * 
	 * @param array $row
	 * @param int $row_index
	 * @return string
	 */
	protected function catTraceRow(Array $row, $row_index) {
		print_r($row);
		$element  = '#'.$row_index.' ';
		$element .= $row['file'].'('.$row['line'].'): ';
		$element .= $row['function'];
		$element .= '()';
		return $element;
		/*if()
		$element = $row['args'];
		
		
		#1 /Users/gregtedder/git/mainframework/mfw/system/log/MFWLog.php(55): mfw\system\log\MessageLogger->__construct(Object(mfw\system\log\LogMessage))
		
		[0]=>
array(4) {
    ["file"] => string(10) "/tmp/a.php"
    ["line"] => int(10)
    ["function"] => string(6) "a_test"
    ["args"]=>
    array(1) {
      [0] => &string(6) "friend"*/
    }

	
	
}
 
}

?>