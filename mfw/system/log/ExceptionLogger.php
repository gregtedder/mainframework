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
 
 /** 
  * 
  * grep -B1 -A1 index.php mf_log-2013_03_22.log
  * 
  * awk '/cron\.allow/,/pattern|^$/' file
  * 
  * sed -n '/index.php/,/^#/p' $file
  * 
  * awk '/index\.php/,/pattern|^!#/' mf_log-2013_03_22.log
  * 
  * 
  * {if (a && a !~ /foo/) print a; print} {a=$0}
  * 
  * awk '/index\.php/{if (a && a !~ /index\.php/) print a; print} {a=$0},/^#/p' $file
  * 
  * 
  *  awk '/index\.php/,/pattern|^!#/{if (a && a !~ /index\.php/) print a; print} {a=$0}' mf_log-2013_03_22.log
  * 
  * 
  * 
  * 
  */
 
 namespace mfw\system\log {
 
 class ExceptionLogger implements Loggable {
 	
	/** 
	 * 
	 * @var string
	 */
	private $message;
 	
	/** 
	 * 
	 * @param \Exception $e
	 */
	public function __construct(\Exception $e) {
		$message = date('Y-m-d H:i:s e');
		if(isset($_SERVER)) {
			$message .= ' - ' . $_SERVER['REMOTE_ADDR'];
			$message .= ' - ' . $_SERVER['REQUEST_URI'];
		}
		$message .= ' | ';
		$message .= $e->getMessage() . PHP_EOL;
		$message .= '#  ' . $e->getFile() . ' - Line: ';
		$message .= $e->getLine() . ' - Code: ';
		$message .= $e->getCode() . ' - ';
		$message .= $e->getTraceAsString();
		$message .= PHP_EOL;
		$this->message = $message;
	}
	
	/** 
	 * 
	 * @return string
	 */
	public function getMessage() {
		return $this->message;
	}
	
 }
 
 }

?>