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

class MysqlResultIterator extends \mfw\system\db\DatabaseResultIterator {
	
	private $result_set;
	
	private $position = 0;
	
	private $current_row = false;
	
	/**
	 *
	 * Use this to escape returns
	 *
	 * @var array
	 */
	private $tableInfo = null;

    public function __construct($result_set, $tableInfo = null) {
        $this->result_set = $result_set;
		$this->next();
		$this->position = 0;
		if($tableInfo != null) {
			$this->tableInfo = array();
			foreach($tableInfo as $key => $row) {
				$this->tableInfo[$row->Field] = $row->Type;
			}
		}
    }

    function rewind() {
		mysql_data_seek($this->result_set, 0);
		$this->next();
		$this->position = 0;
    }

    function current() {
        return $this->current_row;
		
    }

    function key() {
        return $this->position;
    }

    function next() {
        $this->position++;
		$this->current_row = mysql_fetch_object($this->result_set);
		/*if($this->tableInfo != null) {
			foreach($this->current_row as $key => $value) {
				$this->current_row->$key = $this->unScrubData($value, $this->tableInfo[$key]);
			}
		}*/
    }

    function valid() {
        if($this->current_row == false)
			return false;
		return true;
    }
	
	/**
	 *
	 * Clean the data for use in queries
	 *
	 * @param mixed $value
	 * @param string $type
	 */
	public function unScrubData($value, $type) {
		if(stristr($type, 'int')) // cast
			$data = (int)$value;
		else if(stristr($type, 'float'))
			$data = (float)$value;
		else if(stristr($type, 'double'))
			$data = (double)$value;
		else
			$data = stripslashes($value);
		return $data;
	}
	
}

}

?>