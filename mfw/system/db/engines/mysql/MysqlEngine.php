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

namespace mfw\system\db\engines\mysql
{

class MysqlEngine implements \mfw\system\db\DatabaseEngine {
	
	/**
	 *
	 * The reference to the open mysql connection
	 *
	 * @var reference
	 */
	private $connection;
	
	/**
	 *
	 */
	public function __construct() {
		
	}
	
	/**
	 *
	 * Connect to the database
	 *
	 * Pull credentials from config defines
	 */
	public function connect() {
		$this->connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
		if(DB_DEFAULT_SCHEMA != '')
			mysql_selectdb(DB_DEFAULT_SCHEMA, $this->connection);
	}
	
	/**
	 *
	 * Disconnect from the database
	 */
	public function disconnect() {
		mysql_close($this->connection);
	}
	
	/**
	 *
	 * Set or change schema
	 *
	 * @param string $schema
	 */
	public function setSchema($schema) {
		if(trim($schema) == '')
			throw new ErrorException("MysqlEngine->setSchema: arg 0 is empty");
		mysql_selectdb($schema, $this->connection);
	}
	
	/**
	 *
	 * Returns an iterable result set
	 *
	 * @throws Exception
	 *
	 * @param string $sql
	 * @return \mfw\system\db\engines\mysql\MysqlResultIterator
	 */
	public function getResults($sql) {
		$result = mysql_query($sql, $this->connection);
		if(!$result) {
			throw new ErrorException(mysql_error($this->connection) . PHP_EOL . $sql);
		}
		if(mysql_num_rows($result) <= 0) {
			throw new Exception('No Results' . PHP_EOL . $sql);
		}
		return new \mfw\system\db\engines\mysql\MysqlResultIterator($result);
	}
	
	/**
	 *
	 * Returns a single data row
	 *
	 * @throws Exception
	 *
	 * @param string $sql
	 * @return Object
	 */
	function getResult($sql) {
		$result = mysql_query($sql, $this->connection);
		if(!$result) {
			throw new ErrorException(mysql_error($this->connection) . PHP_EOL . $sql);
		}
		if(mysql_num_rows($result) <= 0) {
			throw new Exception('No Results' . PHP_EOL . $sql);
		}
		return mysql_fetch_object($result);
	}
	
	/**
	 *
	 * Inserts data and returns unique key in some cases
	 *
	 * @throws Exception
	 *
	 * @param string $sql
	 * @return int
	 */
	function insert($sql) {
		$result = mysql_query($sql, $this->connection);
		if(!$result) {
			throw new ErrorException(mysql_error($this->connection) . PHP_EOL . $sql);
		}
		return mysql_insert_id();
	}
	
	/**
	 *
	 * Updates data
	 *
	 * @throws Exception
	 *
	 * @param string $sql
	 */
	function update($sql) {
		$result = mysql_query($sql, $this->connection);
		if(!$result) {
			throw new ErrorException(mysql_error($this->connection) . PHP_EOL . $sql);
		}
	}
	
	/**
	 *
	 * Get the results of a query and pull from un-escaped results.
	 *
	 * @param string $table
	 * @param string $where
	 * @param string $select
	 * @return
	 */
	public function findRowsInTable($table, $where = '', $select = '', $order = '') {
		$sql = "SHOW COLUMNS FROM $table";
		$iterator = $this->getResults($sql);
		if($select == '') { $select = '*'; }
		if($where != '') { $where = " WHERE $where"; }
		if($order != '') {$order = " ORDER BY $order"; }
		$sql = "SELECT $select FROM $table $where $order";
		$result = mysql_query($sql, $this->connection);
		if(!$result) {
			throw new ErrorException(mysql_error($this->connection) . PHP_EOL . $sql);
		}
		if(mysql_num_rows($result) <= 0) {
			throw new Exception('No Results' . PHP_EOL . $sql);
		}
		return new \mfw\system\db\engines\mysql\MysqlResultIterator($result, $iterator);
	}
	
	/**
	 *
	 * Write a php Object to the specified table
	 *
	 * @param string $table
	 * @param Object $row
	 * @param return int unique ID
	 */
	public function insertRowInTable($table, $insert_row) {
		$sql = "SHOW COLUMNS FROM $table";
		$iterator = $this->getResults($sql);
		$sql = "INSERT INTO $table SET";
		$first = true;
		foreach($iterator as $row) {
			$extra = $row->Extra;
			$field = $row->Field;
			$type = $row->Type;
			if(stristr($extra, 'auto_increment')) // don't set autoincrement fields
				continue;
			else if(!array_key_exists($row->Field, $insert_row)
			&& $row->Null == 'NO') // validate
				throw new \ErrorException("Insertion row is missing non-null field: " . $row->Field);
			$sql .= $this->buildSet($field, $insert_row->$field, $type, $first);
			$first = false;
		}
		echo $sql;
	}
	
	/**
	 *
	 * Update the specified table using an associative array
	 *
	 * Specify where or check the table for Primary Keys
	 *
	 * @param string $table
	 * @param Object $row
	 * @param string $where
	 */
	public function updateRowInTable($table, $insert_row, $where = '') {
		$sql = "SHOW COLUMNS FROM $table";
		$iterator = $this->getResults($sql);
		$sql = "UPDATE $table SET";
		$where_sql = $where;
		$first = true;
		foreach($iterator as $row) {
			$extra = $row->Extra;
			$field = $row->Field;
			$type = $row->Type;
			$value = $insert_row->$field;
			if(stristr($extra, 'auto_increment') || stristr($row->Key, 'PRI')) {
				$where_value = $this->scrubData($value, $type);
				if($where == '')
					if($where_sql == '')
						$where_sql .= " $field = '$value'";
					else
						$where_sql .= " AND $field = '$value'";
				continue;
			} else if(!array_key_exists($field, $insert_row)
			&& $row['Null'] == 'NO') { // validate
				throw new \ErrorException("Insertion row is missing non-null field: " . $row->Field);
			}
			$sql .= $this->buildSet($field, $value, $type, $first);
			$first = false;
		}
		if($where_sql == '')
			throw new \ErrorException("Update is missing WHERE statement.");
		$sql .= " WHERE " . $where_sql;
		echo $sql;
	}
	
	/**
	 *
	 * Delete from the specified table using an associative array
	 *
	 * Specify where or check the table for Primary Keys
	 *
	 * @param string $table
	 * @param Object $delete_row
	 * @param string $where
	 */
	public function deleteRowInTable($table, $delete_row, $where = '') {
		$sql = "SHOW COLUMNS FROM $table";
		$iterator = $this->getResults($sql);
		$sql = "DELETE FROM $table WHERE";
		$where_sql = $where;
		foreach($iterator as $row) {
			$extra = $row->Extra;
			$field = $row->Field;
			$type = $row->Type;
			$value = $delete_row->$field;
			if(stristr($extra, 'auto_increment') || stristr($row->Key, 'PRI')) {
				$where_value = $this->scrubData($value, $type);
				if($where == '')
					if($where_sql == '')
						$where_sql .= " $field = '$value'";
					else
						$where_sql .= " AND $field = '$value'";
				continue;
			} 
		}
		if($where_sql == '')
			throw new \ErrorException("Delete is missing WHERE statement.");
		$sql .= $where_sql;
		echo $sql;
	}
	
	/**
	 *
	 * Clean the data for use in queries
	 *
	 * @param mixed $value
	 * @param string $type
	 */
	public function scrubData($value, $type) {
		if(stristr($type, 'int')) // cast
			$data = (int)$value;
		else if(stristr($type, 'float'))
			$data = (float)$value;
		else if(stristr($type, 'double'))
			$data = (double)$value;
		else
			$data = mysql_real_escape_string($value);
		return $data;
	}
	
	/**
	 *
	 * Create the SET routine for an sql query
	 *
	 * @return string
	 */
	protected function buildSet($field, $value, $type, $first) {
		$value = $this->scrubData($value, $type);
		$sql = "";
		if(!$first)
			$sql = ", ";
		$sql .= " $field = '$value'";
		return $sql;
	}
	
}

}

?>