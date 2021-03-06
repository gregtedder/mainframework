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
 * 
 * This class manages writing to and creating 
 * daily log files for MFW.
 * 
 */
class Log {
	
	/** 
	 * 
	 * @param string $message
	 */
	public static function log($message) {
		$append = date('Y-m-d H:i:s e');
		if(isset($_SERVER)) {
			$append .= ' - ' . $_SERVER['REMOTE_ADDR'];
			$append .= ' - ' . $_SERVER['REQUEST_URI'];
		}
		$append .= ' | ' . $message . PHP_EOL;
		self::writeToLog($append);
	}
	
	/** 
	 * 
	 * @param string $message
	 */
	private static function writeToLog($message) {
		$file_name = MFW_PATH . '/mfw/logs/' . self::getDailyLogName();
		file_put_contents($file_name, $message, FILE_APPEND);
	}
	
	/** 
	 * 
	 * @return string
	 */
	private static function getDailyLogName() {
		return 'mf_log-'.date('Y_m_d').'.log';
	}
	
}

}

?>