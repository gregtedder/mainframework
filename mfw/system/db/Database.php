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

namespace mfw\system\db
{

/**
 *
 * Database
 *
 * Singleton
 *
 * Adapter
 *
 * Create an engine, and offer access to higher level functionality.
 *
 * This class will be used to create the configured database engine.
 *
 */
class Database extends \mfw\system\db\DatabaseAdapter {
	
	/**
	 *
	 * @var \mfw\system\db\Database
	 */
	private static $instance;
	
	/**
	 *
	 * This reads the DB_ENGINE constant in config
	 *
	 * @param \mfw\system\db\Database
	 */
	public static function init() {
		if(empty(self::$instance)) {
			self::$instance = new Database();
		}
		return self::$instance;
	}
	
	/**
	 *
	 * Do not call this directly
	 *
	 */
	public function __construct() {
		switch(DB_ENGINE) {
			case 'mysql':
				$this->dbEngine = new \mfw\system\db\engines\mysql\MysqlEngine();
				break;
			default:
				throw new Exception("DB_ENGINE is not configured correctly. Look in config/database.php");
				break;
		}
		$this->dbEngine->connect();
	}
	
}

}
?>