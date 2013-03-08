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
 * The interface for all DB Engines.
 *
 */
interface DatabaseEngine {
	
	/**
	 *
	 * Connect to the database
	 */
	function connect();
	
	/**
	 *
	 * Disconnect from the database
	 */
	function disconnect();
	
	/**
	 *
	 * Set or change schema
	 *
	 * @param string $schema
	 */
	function setSchema($schema);
	
	/**
	 *
	 * Returns an iterable result set
	 *
	 * @throws Exception
	 *
	 * @param string $sql
	 * @return Model
	 */
	function getResults($sql);
	
	/**
	 *
	 * Returns a single data row
	 *
	 * @throws Exception
	 *
	 * @param string $sql
	 * @return array
	 */
	function getResult($sql);
	
	/**
	 *
	 * Inserts data and returns unique key in some cases
	 *
	 * @throws Exception
	 *
	 * @param string $sql
	 * @return int
	 */
	function insert($sql);
	
	/**
	 *
	 * Updates data
	 *
	 * @throws Exception
	 *
	 * @param string $sql
	 */
	function update($sql);
	
	// Tranactional SQL
	/*function start();
	
	function commit();
	
	function rollback();*/
	
	/**
	 *
	 * Get the results of a query and pull from un-escaped results.
	 *
	 * @param string $table
	 * @param string $where
	 * @param string $select
	 * @return
	 */
	public function findRowsInTable($table, $where = '', $select = '', $order = '');
	
	/**
	 *
	 * Write a php Object to the specified table
	 *
	 * @param string $table
	 * @param Object $row
	 * @param return int unique ID
	 */
	public function insertRowInTable($table, $insert_row);
	
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
	public function updateRowInTable($table, $insert_row, $where = '');
	
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
	public function deleteRowInTable($table, $delete_row, $where = '');
	
	/**
	 *
	 * Clean the data for use in queries
	 *
	 * @param mixed $value
	 * @param string $type
	 */
	public function scrubData($value, $type);
	
}
	
}

?>