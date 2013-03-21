<?php

namespace mfw\system {

/** 
 * 
 * This class manages daily log files for the framework
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